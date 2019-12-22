<?php
require 'db.inc.php';
ini_set('display_errors', true);
session_start();

$action = isset($_POST['action']) ? $_POST['action'] : null;

if(!isset($_SESSION['pm']) && $action != 'login')
    header('Location:login.php');
$pm = $_SESSION['pm'];

switch ($action) {
    case 'set_task_complete':
        $tid = $_POST['task_id'];
        $wh = $_POST['working_hours'];
        $stmt = $link->prepare('UPDATE `task` SET `is-complete` = 1, `actual-working-days` = ? WHERE `id` = ?');
        $stmt->bind_param('ii', $wh, $tid);
        $stmt->execute();
        break;
    case "add-member":
        $member_name = $_POST['member'];
        $stmt = $link->prepare('INSERT INTO `member` VALUES (null, ?) ');
        $stmt->bind_param('s', $member_name);
        $stmt->execute();
        break;
    case "add-task":
        $pid = $_POST['project-id'];
        $task_name = $_POST['task-name'];
        $start_date = $_POST['start-date'];
        $end_date = $_POST['end-date'];
        $working_days = $_POST['working-days'];
        $milestone = isset($_POST['milestone']);
        $predecessors = $_POST['predecessors'] ?? [];
        $parent = $_POST['parent'];
        $mem_working_hours = $_POST['working_hours'] ?? [];
        $plan_cfg = json_decode(file_get_contents('plan_cfg.json'), true);
        $working_hrs = $working_days * $plan_cfg['hrs'];
        // Check if within project timeline
        $stmt = $link->prepare('SELECT `start-date`, `end-date` FROM `project` WHERE `id` = ?');
        $stmt->bind_param('i', $pid);
        $stmt->bind_result($proj_start_date, $proj_end_date);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();
        if(strtotime($start_date) < strtotime($proj_start_date) || strtotime($end_date) > strtotime($proj_end_date)){
            echo "Sorry, the selected start and end dates are outside the project's time range";
            exit();
        }
        // Check parent task start and end
        if($parent !== 'NULL'){
            $stmt = $link->prepare('SELECT `start-date`, `end-date`, `working-days` FROM `task` WHERE `id` = ?');
            echo $link->error;
            $stmt->bind_param('i', $parent);
            $stmt->bind_result($p_start_date, $p_end_date, $p_working_hours);
            $stmt->execute();
            $stmt->fetch();
            $stmt->close();
            if(strtotime($start_date) < strtotime($p_start_date) || strtotime($end_date) > strtotime($p_end_date)){
                echo "Sorry, the selected start and end dates are outside the parent task's range";
                exit();
            }
            $stmt = $link->prepare('SELECT `working-days` FROM `task` WHERE `parent-task-id` = ?');
            $stmt->bind_param('i', $parent);
            $stmt->bind_result($sibling_wh);
            $stmt->execute();
            $total_hours = $working_hrs;
            while($stmt->fetch()) $total_hours += $sibling_wh;
            $stmt->close();
            if($total_hours > $p_working_hours){
                echo "Sorry total hours for this task and it's siblings exceed the parent's assigned total hours";
                exit();
            }
        }
        $stmt = $link->prepare('INSERT INTO `task` (`name`, `start-date`, `end-date`, `working-days`, `parent-task-id`, `is-milestone`, `project-id`) VALUES (?,?,?,?,NULLIF(?,0),?,?)');
        $stmt->bind_param('sssiiii', $task_name, $start_date, $end_date, $working_hrs, $parent, $milestone, $pid);
        $stmt->execute();
        $tid = mysqli_insert_id($link);
        foreach ($predecessors as $pre) {
            $stmt = $link->prepare('INSERT INTO `task-dependency` VALUES (?,?)');
            $stmt->bind_param('ii', $pre, $tid);
            $stmt->execute();
        }
        $stmt->close();
        $stmt = $link->prepare('INSERT INTO `task-members` VALUES (?,?,?)');
        $stmt->bind_param('iii', $tid, $mid, $wh);
        foreach($mem_working_hours as $t){
            $ta = explode('_', $t);
            $mid = $ta[0];
            $wh = $ta[1];
            $stmt->execute();
        }
        $stmt->close();
        header('Location:project_info.php?id=' . $pid);
        break;
    case "add-project":
        $deliverables = $_POST['deliverables'] ?? [];
        $name = $_POST["Name"];
        $StartDate = $_POST["StartDate"];
        $EndDate = $_POST["EndDate"];
        $Cost = $_POST["Cost"];
        $HoursperDay = $_POST["HoursperDay"];
        $titles = $_POST['titles'] ?? [];
        // TODO: Use prepared statement or atleast escape input
        $sql = "INSERT INTO project (`name`, `hours-per-day`, `cost`, `start-date`, `end-date`, `pm-id`) VALUES ('$name','$HoursperDay','$Cost', '$StartDate', '$EndDate', '$pm')";
        mysqli_query($link, $sql);
        $id = mysqli_insert_id($link);
        foreach ($deliverables as $deliverable) {
            $insert = $link->prepare('INSERT INTO `deliverables` (`project-id`, `title`) VALUES (?,?)');
            $insert->bind_param('is', $id, $deliverable);
            $insert->execute();
        }
        $stmt = $link->prepare('INSERT INTO `project-member-titles` VALUES (?, ?, ?)');
        $stmt->bind_param('iis', $id, $mid, $title);
        foreach($titles as $t){
            $ta = explode('_', $t);
            $mid = $ta[0];
            $title = $ta[1];
            $stmt->execute();
        }
        $stmt->close();
        header('Location:Projects.php');
        break;
   
    case "login":
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $link->prepare("SELECT id, name FROM `project-managers` WHERE username = ? AND password = ?");
        $stmt->bind_param('ss', $username, $password);
        $stmt->bind_result($id, $name);
        $stmt->execute();
        if($stmt->fetch()) {
            $_SESSION['pm'] = $id;
            header('Location:Projects.php?pm-name='.$name);
        }else{
            echo "<script> alert ('invalid username or Password'); </script>";
            header('Location:login.php');
        }

    break;
    case "check-username":
        $username = $_POST['username'];
        $stmt = $link->prepare("SELECT * FROM `project-managers` WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        if ($stmt->fetch())
            echo "EXISTS";
        else
            echo "ADD";
        break;
    case "add-manager":
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $stmt = $link->prepare("INSERT INTO `project-managers` (name, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $username, $password);
        $stmt->execute();
        header('Location:login.php');
        break;
    case "delete-project":
        $pid = $_POST['pid'];
        $stmt = $link->prepare("SELECT * FROM `project` WHERE pid = ? AND pm-id = ?");
        $stmt->bind_param('ii', $pid, $pm);
        $stmt->execute();
        if (!$stmt->fetch()) {
            echo "<script> alert ('Project not found or you're not authorized to delete it'); </script>";
        } else {
            $stmt = $link->prepare("DELETE FROM `project` WHERE id = ?");
            $stmt->bind_param('i', $pid);
            $stmt->execute();
        }
        break;
    case "plan-config":
        $day = $_POST['day'];
        $hrs = $_POST['hrs'];
        $data = json_encode(array(
            'day' => $day,
            'hrs' => $hrs
        ));
        file_put_contents('plan_cfg.json', $data);
        break;
        
}
