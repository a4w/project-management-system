<?php
ini_set('display_errors', true);
require 'db.inc.php';

$pid = $_GET['id'] ?? 0;

$stmt = $link->prepare('SELECT * FROM `project` WHERE `id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($id, $name, $hpd, $cost, $start_date, $end_date);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $link->prepare('SELECT * FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $id);
$stmt->bind_result($tid, $tname, $tstart_date, $tworking_hours, $tend_date, $parent_id, $tis_complete, $tactual_working_hours, $tis_milestone, $pid);
$stmt->execute();

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
                    <span>ID: <?= $id ?></span>
                </div>
                <div class="col-12">
                    <span>NAME: <?= $name ?></span>
                </div>
                <div class="col-12">
                    <span>Start date: <?= $start_date ?></span>
                </div>
                <div class="col-12">
                    <span>Due date: <?= $end_date ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-right m-2">Add Task</button>
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
                            <th>Predecessors</th>
                            <th>Parent task</th>
                            <th>Is Milestone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php
                            $stmt->store_result();
                            $dependency_stmt = $link->prepare('SELECT `main-task` FROM `task-dependency` WHERE `dependent-task` = ?');
                            $dependency_stmt->bind_param('i', $tid);
                            $dependency_stmt->bind_result($main_task);
                            while($stmt->fetch()){
                                $button = $tis_complete ? 'No Action' : "<button class='btn btn-sm btn-warning set-as-complete' data-target='{$tid}'>Set as complete</button>";
                                $complete_str = $tis_complete ? 'Complete' : 'Pending';
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
                                echo "
                                    <tr>
                                        <td>{$tid}</td>
                                        <td>{$tname}</td>
                                        <td>{$members_str}</td>
                                        <td>{$tstart_date}</td>
                                        <td>{$tend_date}</td>
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
