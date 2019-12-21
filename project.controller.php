<?php
require 'db.inc.php';
ini_set('display_errors', true);

$action = isset($_POST['action']) ? $_POST['action'] : null;

switch ($action) {
    case 'set_task_complete':
        $tid = $_POST['task_id'];
        $wh = $_POST['working_hours'];
        $stmt = $link->prepare('UPDATE `task` SET `is-complete` = 1, `actual-working-hours` = ? WHERE `id` = ?');
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
        $working_hrs = $_POST['working-hrs'];
        $milestone = isset($_POST['milestone']);
        $predecessors = $_POST['predecessors'];
        $parent = $_POST['parent'];
        $stmt = $link->prepare('INSERT INTO `task` (`name`, `start-date`, `end-date`, `working-hours`, `parent-task-id`, `is-milestone`, `project-id`) VALUES (?,?,?,?,NULLIF(?,0),?,?)');
        $stmt->bind_param('sssiiii', $task_name, $start_date, $end_date, $working_hrs, $parent, $milestone, $pid);
        $stmt->execute();
        $tid = mysqli_insert_id($link);
        foreach ($predecessors as $pre) {
            $stmt = $link->prepare('INSERT INTO `task-dependency` VALUES (?,?)');
            $stmt->bind_param('ii', $pre, $tid);
            $stmt->execute();
        }
        header('Location:Project_info.php?id=' . $pid);
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
        $sql = "INSERT INTO project (`name`, `hours-per-day`, `cost`, `start-date`, `end-date`, `pm-id`) VALUES ('$name','$HoursperDay','$Cost', '$StartDate', '$EndDate', '1')";
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
            var_dump($stmt->error);
        }
        $stmt->close();
        header('Location:Projects.php');
        break;
}
