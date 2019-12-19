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
                    <h1>Project Name</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <span>ID: 0</span>
                </div>
                <div class="col-12">
                    <span>NAME: NAME</span>
                </div>
                <div class="col-12">
                    <span>Start date: NAME</span>
                </div>
                <div class="col-12">
                    <span>Due date: </span>
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
                            <th>Assigne</th>
                            <th>Start date</th>
                            <th>End date</th>
                            <th>Working hours</th>
                            <th>Predecessors</th>
                            <th>Is Milestone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Create project</td>
                            <td>Sara Samer <small>(CEO)<small></td>
                            <td>2019-12-24</td>
                            <td>2019-12-30</td>
                            <td>450</td>
                            <td>1,5,9</td>
                            <td>YES</td>
                            <td>Pending</td>
                            <td><button class="btn btn-sm btn-warning set-as-complete" data-target="1">Set as complete</button></td>
                        </tr>
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
                window.location.reload(true);
            });

        </script>
    </body>

</html>
