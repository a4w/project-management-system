<?php
ini_set('display_errors', true);
require 'db.inc.php';

$pid = isset($_GET['pid']) ? $_GET['pid'] :  0;
$stmt = $link->prepare('SELECT `name`, `id` FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($name, $tid);
$stmt->execute();
$ptask = array();
while ($stmt->fetch()) {
    $ptask[] = [$tid, $name];
}
$stmt->close();
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
        <form action="project.controller.php" method="POST">
            <input type="hidden" name="action" value="add-task">
            <input type="hidden" name="project-id" value="<?= $pid ?>">
            <div class="row">
                <div class="col-12">
                    <h1 class="m-1">Add Task</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Name</label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control m-1" name="task-name">
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Start date</label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control m-1" name="start-date">
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">End date</label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control m-1" name="end-date">
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Working Hours</label>
                </div>
                <div class="col-3">
                    <input type="number" step="1" min="0" class="form-control m-1" name="working-hrs">
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Is Milestone</label>
                </div>
                <div class="col-3">
                    <input type="checkbox" class="form-control m-1" name="milestone">
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Predecessors</label>
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" name="predecessors[]" size="<?= mysqli_num_rows($stmt)?>">
                        <?php
                        foreach ($ptask as $task) {
                            echo "<option value='{$task[0]}'>{$task[1]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Main Task</label>
                </div>
                <div class="col-3">
                    <select class="form-control m-1" name="parent">
                        <option value="NULL">None</option>
                        <?php
                        foreach ($ptask as $task) {
                            echo "<option value='{$task[0]}'>{$task[1]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Assign Members</label>
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" name="members[]" size="<?= mysqli_num_rows($members)?>">
                        <?php
                            $stmt->store_result();
                            $members = $link->prepare('SELECT * FROM `member`');
                            $members->bind_result($mid, $mname);
                            $members->execute();
                            while ($members->fetch()) {
                                echo "<option value='{$mid}'>{$mname}</option>";
                            }
                            $members->close();
                        ?>
                    </select>
                </div>
                <div class="col-1">
                    <!--
                        buttons
                        -->
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" name="members[]" size="<?= mysqli_num_rows($members)?>">
                        
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input class="btn btn-primary float-right m-3" type="submit" value="Add Task">
                </div>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>