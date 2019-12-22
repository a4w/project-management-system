<?php
require 'db.inc.php';
ini_set('display_errors', true);
$pid = $_GET['pid'];
$stmt = $link->prepare('SELECT * FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($id, $name, $start_date, $end_date, $working_hours, $parent_task_id, $is_complete, $actual_working_hours, $is_milestone, $project_id);
$stmt->execute();
$stmt->store_result();

$depend_stmt = $link->prepare('SELECT `main-task` FROM `task-dependency` WHERE `dependent-task` = ?');
$depend_stmt->bind_param('i', $id);
$depend_stmt->bind_result($dependency_id);

$js_chart_data = '';
while($stmt->fetch()){
    $dependencies = array();
    $depend_stmt->execute();
    $depend_stmt->store_result();
    while($depend_stmt->fetch()){
        $dependencies[] = $dependency_id;
    }
    $working_hours *= 60 * 60 * 1000;
    $percent = $is_complete === 1 ? 100 : 0;
    $dependencies_str = implode(',', $dependencies);
    if($actual_working_hours === null) $actual_working_hours = $working_hours;
    $actual_working_hours *= 60 * 60 * 1000;
    // Detect, if dependent
    if(count($dependencies) > 0){
        $js_chart_data .= "['$id', '$name', null, null, $actual_working_hours, $percent, '$dependencies_str'],";
    }else{
        $js_chart_data .= "['$id', '$name', new Date(Date.parse('$start_date')), null, $actual_working_hours, $percent, ''],";
    }
    $js_chart_data .= PHP_EOL;
}

?>
<html>
    <head>
        <title>Project Actual plan</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1>Project Actual Chart</h1>
                    <hr />
                    <br />
                </div>
            </div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <div id="chart"></div>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script>
            google.charts.load('current', {'packages':['gantt']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart(){
                let data = new google.visualization.DataTable();
                data.addColumn('string', 'Task ID');
                data.addColumn('string', 'Task Name');
                data.addColumn('date', 'Start Date');
                data.addColumn('date', 'End Date');
                data.addColumn('number', 'Duration');
                data.addColumn('number', 'Percent Complete');
                data.addColumn('string', 'Dependencies');

                data.addRows([ <?= $js_chart_data ?> ]);

                let options = {
                    height: 500
                };

                let chart = new google.visualization.Gantt(document.getElementById('chart'));
                chart.draw(data, options);
            }

        </script>
    </body>
</html>
