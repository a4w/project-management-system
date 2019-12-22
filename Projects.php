<?php
ini_set('display_errors', true);
require 'db.inc.php';

session_start();

if(!isset($_SESSION['pm']))
    header('Location:login.php');
$pm_id = $_SESSION['pm'];

$stmt = $link->prepare('SELECT `name` FROM `project-managers` WHERE `id` = ? ');
$stmt->bind_param('i', $pm_id);
$stmt->bind_result($pm_name);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $link->prepare('SELECT `day`, `hrs-per-day` FROM `plan-cfg` WHERE `pm-id` = ?');
$stmt->bind_param('i', $pm_id);
$stmt->bind_result($pcfg_day, $pcfg_hrs);
$stmt->execute();
$stmt->fetch();
$stmt->close();

$stmt = $link->prepare('SELECT * FROM `project` WHERE `pm-id` = ?');
$stmt->bind_param('i', $pm_id);
$stmt->bind_result($id, $dummy, $name, $hpd, $cost, $start_date, $end_date);
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
                <h1>Projects Managed by: <?= $pm_name ?> </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-danger float-right m-2" id="delete-project-btn">Delete Project</button>
                <a class="btn btn-primary float-right m-2" href="add_project.php">Add Project</a>
                <button class="btn btn-primary float-right m-2" id="add-member-btn">Add Member</button>
                <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target="#myModal">Edit Plan Config</button>
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Plan Configuration</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="pm" value="<?= $pm_id ?>">
                                <div class="form-group">
                                    <label class="col-4 control-label">Start Day: </label>
                                    <div class="col">
                                        <input type="radio" name="day" <?= $pcfg_day == 0 ? 'checked' : '' ?> name="day" value="0"> Sunday
                                        <input type="radio" name="day" <?= $pcfg_day == 1 ? 'checked' : '' ?> name="day" value="1"> Monday
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col control-label">Working Hours Per Day: </label>
                                    <div class="col">
                                        <input type="number" name="working-hrs" value="<?=$pcfg_hrs?>" id="working-hrs" min="1" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="save">Save</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table">
                    <tr>
                        <th>Project ID</th>
                        <th>Project name</th>
                        <th>Hours Per Day</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Cost</th>
                        <th>Deliverables</th>
                        <th>Info</th>
                    </tr>

                    <?php
                    $stmt->store_result();
                    $d_stmt = $link->prepare('SELECT `title` FROM `deliverables` WHERE `project-id` = ?');
                    $d_stmt->bind_param('i', $id);
                    $d_stmt->bind_result($d_title);
                    while ($stmt->fetch()) {
                        $d_stmt->execute();
                        $titles = array();
                        while ($d_stmt->fetch()) {
                            $titles[] = $d_title;
                        }
                        $titles_str = implode('<br />', $titles);
                        echo "
                                        <tr>
                                            <td>{$id}</td>
                                            <td>{$name}</td>
                                            <td>{$hpd}</td>
                                            <td>{$start_date}</td>
                                            <td>{$end_date}</td>
                                            <td>{$cost}</td>
                                            <td>{$titles_str}</td>
                                            <td> <a href = 'project_info.php?id=$id'> view info </a></td>
                                        </tr>
                                    ";
                    }
                    $stmt->close();
                    $d_stmt->close();
                    ?>
                </table>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $("#add-member-btn").click(function() {
            const member = prompt("member name");
            $.post("project.controller.php", {
                "action": "add-member",
                "member": member
            });
        });
        $("#delete-project-btn").click(function() {
            const pid = prompt("Project ID");
            $.post("project.controller.php", {
                "action": "delete-project",
                "pid": pid
            }).done(function(data){
                    window.location.reload(true);
                }); 
        });
        $("#save").click(function() {
            const day = $("input[name=day]:checked").val();
            const hrs = $("#working-hrs").val();
            $.post("project.controller.php", {
                "action": "plan-config",
                "day": day,
                "hrs": hrs,
            });
        });
    </script>
</body>

</html>
