<?php
ini_set('display_errors', true);
require 'db.inc.php';

$stmt = $link->prepare('SELECT * FROM `project`');
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
                    <h1>Projects</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-primary float-right m-2" href="add_project.php">Add Project</a>
                    <button class="btn btn-primary float-right m-2" id="add-member-btn">Add Member</button>
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
							while($stmt->fetch()){
									$d_stmt->execute();
									$titles = array();
									while($d_stmt->fetch()){
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
            $("#add-member-btn").click(function(){
                const member = prompt("member name");
                $.post("project.controller.php", {"action":"add-member","member":member});
            });
        </script>
    </body>

</html>
