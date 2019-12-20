<?php
ini_set('display_errors', true);
require 'db.inc.php';

$pid = isset($_GET['pid']) ? $_GET['pid'] :  0;
$stmt = $link->prepare('SELECT `name`, `id` FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($name, $tid);
$stmt->execute();
$ptask = array();

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
            <form action="project.controller.php" method="POST" >
                <input type="hidden" name="action" value="add-task">
                <div class="row">
                    <div class="col-12">
                        <h1>Add Task</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Name</label> 
                    </div>
                    <div class="col-3">
                        <input type="text" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Start date</label> 
                    </div>
                    <div class="col-3">
                        <input type="date" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>End date</label> 
                    </div>
                    <div class="col-3">
                        <input type="date" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Working Hours</label> 
                    </div>
                    <div class="col-3">
                        <input type="number" step="1" min="0" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Is Milestone</label> 
                    </div>
                    <div class="col-3">
                        <input type="checkbox" class="form-control" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Predecessors</label> 
                    </div>
                    <div class="col-3">
                        <select multiple class="form-control" >
                            <?php
                                while($stmt->fetch()){
                                    echo "<option>{$name}</option>";
                                }                                
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label>Main Task</label> 
                    </div>
                    <div class="col-3">
                        <select class="form-control" >
                            <?php

                            ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        
    </body>

</html>
