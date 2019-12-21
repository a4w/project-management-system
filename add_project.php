<!DOCTYPE html>
<?php
include 'db.inc.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Add new project</title>
    <link rel='stylesheet' href='css/bootstrap.min.css' />
    <link rel='stylesheet' href='css/style.css' />

</head>

<body>
    <div class="container">
        <form method="post" name="main_form" id="main_form" action="project.controller.php">
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
                    <select multiple size="4" readonly name="deliverables[]" id="deliverables_dd" class="form-control mb-2">

                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label">
                        Members
                    </div>
                </div>
                <div class="col-lg-3">
                    <select multiple id="members_pool" class="form-control">
                        <?php
                            $stmt = $link->prepare('SELECT `id`, `name` FROM `member`');
                            $stmt->bind_result($id, $name);
                            $stmt->execute();
                            while($stmt->fetch()){
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button class="btn btn-sm btn-success d-block mx-auto mb-1" type="button" id="add_member"><b>></b></button>
                    <button class="btn btn-sm btn-danger d-block mx-auto" type="button" id="remove_member"><b><</b></button>
                </div>
                <div class="col-lg-3">
                    <select multiple name="members" id="members" class="form-control">
                    </select>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control" id="title" placeholder="Member title" disabled />
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <input class="btn btn-danger float-right mt-3" value="Add Project" type="button" id="add_project">
                </div>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/js.js"></script>
    <script>
        function addDeliverables() {
            const value = $("#deliverable_txt").val();
            $('#deliverables_dd').append($('<option>', {
                value: value,
                text: value,
                selected: true
            }));
            $("#deliverable_txt").val("").focus();
        };
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
        let member_titles = {};
        $("#members").change(function(){
            const members = $(this).val();
            if(members.length === 1){
                $("#title").attr("disabled", false);
                if(typeof member_titles[members[0]] === "undefined")
                    member_titles[members[0]] = "";
                $("#title").val(member_titles[members[0]]);
                $("#title").attr("data-target", members[0]);
            }else{
                $("#title").attr("disabled", true);
                $("#title").val("");
            }
        });
        $("#title").change(function(){
            const id = $(this).attr("data-target");
            member_titles[id] = $(this).val();
        });
        $("#add_project").click(function(){
            const members = $("#members > option");
            members.each(function(i, e){
                const member_id = $(e).val();
                $("#main_form").append("<input type='hidden' name='titles[]' value='" + member_id + "_" + member_titles[member_id] + "' />");
            });
            document.main_form.submit();
        });

    </script>
</body>


</html>


<!-- 
large screens       lg
medium screens      md
small screen        sm
extra small screen  xs
-->
