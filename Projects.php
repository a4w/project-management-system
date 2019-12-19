<?php
ini_set('display_errors', true);
require 'db.inc.php';

$pid = isset($_GET['id']) ? $_GET['id'] :  0;

$stmt = $link->prepare('SELECT * FROM `project` WHERE `id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($id, $name, $hpd, $cost, $start_date, $end_date);
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
                    <h1>Projects</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary float-right m-2">Add Project</button>
                    <button class="btn btn-primary float-right m-2">Add Member</button>
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
                        </tr>
                        <?php
                            while($stmt->fetch()){
                                echo "
                                    <tr>
                                        <td>{$id}</td>
                                        <td>{$name}</td>
                                        <td>{$hpd}</td>
                                        <td>{$start_date}</td>
                                        <td>{$end_date}</td>
                                        <td>{$cost}</td>
                                        <td></td>
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
    </body>

</html>
