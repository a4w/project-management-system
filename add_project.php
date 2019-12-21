<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add new project</title>
    <link rel='stylesheet' href='css/bootstrap.min.css' />
    <link rel='stylesheet' href='css/style.css' />

</head>

<body>
    <div class="container">
        <form method="post" action="project.controller.php">
            <input type="hidden" name="action" value="add-project">
            <h1>Add Project</h1>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        Name
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="text" name="Name" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        StartDate
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="date" name="StartDate" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        EndDate
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="date" name="EndDate" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        Cost
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="number" name="Cost" min="0" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        Hours/Day
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="number" name="HoursperDay" step="1" min="1" max="24" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        deliverables
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="input-group mb-2">
                        <input type="text" id="deliverable_txt" class="form-control">
                        <div class="input-group-append">
                            <div class="btn btn-success" onclick="addDeliverables()"><b>+</b></div>
                        </div>
                    </div>
                    <select multiple size="4" id="deliverables_dd" name="deliverables[]" class="form-control">

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <input class="btn btn-danger float-right mt-3" value="Add Project" type="submit">
                </div>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/js.js"></script>
    <script>
        function addDeliverables() {
            const select = $("#deliverables_dd");
            const value = $("#deliverable_txt").val();
            select.append("<option>" + value + "</option>");
            $("#deliverable_txt").val("").focus();
        };
    </script>
</body>


</html>


<!-- 
large screens       lg
medium screens      md
small screen        sm
extra small screen  xs
-->
