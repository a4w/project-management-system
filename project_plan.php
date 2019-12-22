<?php
require 'db.inc.php';
$pid = $_GET['pid'];
$stmt = $link->prepare('SELECT * FROM `task` WHERE `project-id` = ?');
$stmt->bind_param('i', $pid);
$stmt->bind_result($id, $name, $start_date, $end_date, $working_hours, $parent_task_id, $is_complete, $actual_working_hours, $is_milestone, $project_id);
$stmt->execute();
$stmt->store_result();

$depend_stmt = $link->prepare('SELECT `main-task` FROM `task-dependency` WHERE `dependent-task` = ?');
$depend_stmt->bind_param('i', $id);
$depend_stmt->bind_result($dependency_id);

?>
<html>
    <head>
    
    </head>
    <body>
        <div id="chart"></div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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

                data.addRows([
<?php
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
                    // Detect, if dependent
                    if(count($dependencies) > 0){
                        echo "['$id', '$name', null, null, $working_hours, $percent, '$dependencies_str'],";
                    }else{
                        echo "['$id', '$name', new Date(Date.parse('$start_date')), null, $working_hours, $percent, '$dependencies_str'],";
                    }
                }
?>
                ]);

                let options = {
                    height: 275
                };

                let chart = new google.visualization.Gantt(document.getElementById('chart'));
                chart.draw(data, options);
            }

        </script>
    </body>
</html>
