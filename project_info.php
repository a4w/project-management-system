<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

require 'db.inc.php';
$pid = isset($_GET['id']) ? $_GET['id'] :  0;

$stmt = $link->prepare('SELECT * FROM `project` WHERE `id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($id, $pm, $name, $hpd, $cost, $start_date, $end_date);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $link->prepare('SELECT * FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $id);
$stmt->bind_result($tid, $tname, $tstart_date, $tend_date, $tworking_hours, $parent_id, $tis_complete, $tactual_working_hours, $tis_milestone, $pid);
$stmt->execute();
$stmt->store_result();
?>
<html>
    <head>
        <title>Project info</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <style>

        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1><?= $name; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span><b>ID:</b> <?= $id ?></span>
                </div>
                <div class="col-12">
                    <span><b>NAME:</b> <?= $name ?></span>
                </div>
                <div class="col-12">
                    <span><b>Start date:</b> <?= $start_date ?></span>
                </div>
                <div class="col-12">
                    <span><b>Due date:</b> <?= $end_date ?></span>
                </div>
                <div class="col-12">
                    <span><b>Hours Per Day:</b> <?= $hpd ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label><b>Deliverables:</b></label>
                    <ol>
                    <?php
                        $d_stmt = $link->prepare('SELECT `title` FROM `deliverables` WHERE `project-id` = ?');
                        $d_stmt->bind_param('i', $pid);
                        $d_stmt->bind_result($d_title);
                        $d_stmt->execute();
                        while($d_stmt->fetch()){
                            echo "<li>{$d_title}</li>";
                        }
                        $d_stmt->close();
                    ?>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-primary float-right m-2" href="add_task.php?pid=<?=$pid?>">Add Task</a>
                    <a class="btn btn-success m-2" href="project_plan.php?pid=<?=$pid?>">Expected plan</a>
                    <a class="btn btn-warning m-2" href="project_actual_plan.php?pid=<?=$pid?>">Actual plan</a>
                    <a class="btn btn-dark m-2" href="project_charts.php?pid=<?=$pid?>">Comapre</a>
                </div>
                <div class="col-12">
                    <table class="table">
                        <tr>
                            <th>Task ID</th>
                            <th>Task name</th>
                            <th>Assignes (hours)</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Working hours</th>
                            <th>Actual Working hours</th>
                            <th>Predecessors</th>
                            <th>Parent task</th>
                            <th>Is Milestone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            $dependency_stmt = $link->prepare('SELECT `main-task` FROM `task-dependency` WHERE `dependent-task` = ?');
                            $dependency_stmt->bind_param('i', $tid);
                            $dependency_stmt->bind_result($main_task);
                            while($stmt->fetch()){
                                $button = $tis_complete ? 'No Action' : "<button class='btn btn-sm btn-warning set-as-complete' data-target='{$tid}'>Set as complete</button>";
                                $complete_str = $tis_complete ? 'Complete' : 'Pending';
                                $tactual_working_hours = $tis_complete ? $tactual_working_hours : 'Pending';
                                $alert = $tis_complete && $tactual_working_hours > $tworking_hours;
                                $milestone_str = $tis_milestone ? 'YES' : 'NO';
                                // Get main tasks
                                $dependency_stmt->execute();
                                $dependencies = array();
                                while($dependency_stmt->fetch()){
                                    $dependencies[] = $main_task;
                                }
                                $dependency_str = implode(',', $dependencies);
                                $dependency_stmt->store_result();
                                $members_stmt = $link->prepare('SELECT `name`, `working-hours` FROM `task-members` JOIN `member` ON `member`.`id` = `task-members`.`member-id` WHERE `task-id` = ?');
                                $members_stmt->bind_param('i', $tid);
                                $members_stmt->bind_result($member_name, $member_working_hours);
                                $members_stmt->execute();
                                $members = array();
                                while($members_stmt->fetch()){
                                    $members[] = $member_name . ' (' . $member_working_hours . ')';
                                }
                                $members_str = implode('<br />', $members);
                                $warn_class = $alert ? 'text-danger font-weight-bold' : '';
                                echo "
                                    <tr class='$warn_class'>
                                        <td>{$tid}</td>
                                        <td>{$tname}</td>
                                        <td>{$members_str}</td>
                                        <td>{$tstart_date}</td>
                                        <td>{$tend_date}</td>
                                        <td>{$tworking_hours}</td>
                                        <td>{$tactual_working_hours}</td>
                                        <td>{$dependency_str}</td>
                                        <td>{$parent_id}</td>
                                        <td>{$milestone_str}</td>
                                        <td>{$complete_str}</td>
                                        <td>{$button}</td>
                                    </tr>
                                ";
                            }
                            $stmt->close();

                        ?>
                    </table>
                </div>
            </div>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>

            $('.set-as-complete').click(function(){
                const id = $(this).attr("data-target");
                const working_hours = prompt("Enter number of hours");
                // Send to server that task {id} is done
                $.post("project.controller.php", {'action': 'set_task_complete', 'task_id': id, 'working_hours': working_hours}).done(function(data){
                    window.location.reload(true);
                }); 
            });

        </script>
    </body>

</html>
