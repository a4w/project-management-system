<?php
ini_set('display_errors', true);
require 'db.inc.php';

$pid = isset($_GET['pid']) ? $_GET['pid'] : 0;
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
        <form name="main_form" id="main_form" action="project.controller.php" method="POST">
            <input type="hidden" name="action" value="add-task">
            <input type="hidden" name="project-id" value="<?= $pid ?>">
            <div class="row">
                <div class="col-12">
                    <h1 class="m-1">Add Task</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">Name</label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control m-1" name="task-name">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">Start date</label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control m-1" name="start-date">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">End date</label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control m-1" name="end-date">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">Working Hours</label>
                </div>
                <div class="col-3">
                    <input type="number" step="1" min="0" class="form-control m-1" name="working-hrs">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">Is Milestone</label>
                </div>
                <div class="col-3">
                    <input type="checkbox" class="form-control m-1" name="milestone">
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="m-1">Predecessors</label>
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" name="predecessors[]" size="<?= mysqli_num_rows($stmt) ?>">
                        <?php
                        foreach ($ptask as $task) {
                            echo "<option value='{$task[0]}'>{$task[1]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
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
                <div class="col-2">
                    <label class="m-1">Assign Members</label>
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" id="members_pool">
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
                    <button class="btn btn-sm btn-success d-block mx-auto mt-4 mb-1" type="button" id="add_member"><b>></b></button>
                    <button class="btn btn-sm btn-danger d-block mx-auto" type="button" id="remove_member"><b><</b></button>
                </div>
                <div class="col-3">
                    <select multiple class="form-control m-1" id="members" >

                    </select>
                </div>
                <div class="col-2">
                    <input type="number" placholder="Working hours" disabled id="working_hours" class="form-control" />
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <input id="add_task" class="btn btn-primary float-right m-3" type="button" value="Add Task">
                </div>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        let member_working_hours = {};
        $("#add_member").click(function(){
            // Get selected members
            const members = $("#members_pool").val();
            for(let member_id of members){
                const option = $("#members_pool option[value='" + member_id + "']");
                $("#members").append(option);
            }
            $("#members").change();
        });
        $("#remove_member").click(function(){
            // Get selected members
            const members = $("#members").val();
            for(let member_id of members){
                const option = $("#members option[value='" + member_id + "']");
                $("#members_pool").append(option);
            }
            $("#members").change();
        });
        $("#members").change(function(){
            const members = $(this).val();
            if(members.length === 1){
                $("#working_hours").attr("disabled", false);
                if(typeof member_working_hours[members[0]] === "undefined")
                    member_working_hours[members[0]] = "0";
                $("#working_hours").val(member_working_hours[members[0]]);
                $("#working_hours").attr("data-target", members[0]);
            }else{
                $("#working_hours").attr("disabled", true);
                $("#working_hours").val("");
            }
        });
        $("#working_hours").change(function(){
            const id = $(this).attr("data-target");
            member_working_hours[id] = $(this).val();
        });
        $("#add_task").click(function(){
            const members = $("#members > option");
            members.each(function(i, e){
                const member_id = $(e).val();
                $("#main_form").append("<input type='hidden' name='working_hours[]' value='" + member_id + "_" + member_working_hours[member_id] + "' />");
            });
            document.main_form.submit();
        });

    </script>

</body>

</html>
