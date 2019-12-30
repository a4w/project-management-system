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
        <form action="project.controller.php" method="POST" class="form">
            <input type="hidden" name="action" value="add-manager">
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Name: </label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control m-1" name="name" required>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">username: </label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control m-1 username" name="username" required>
                </div>
            </div>
            <div class="row">
                <div class="col-1">
                    <label class="m-1">Pasword: </label>
                </div>
                <div class="col-3">
                    <input type="password" class="form-control m-1" name="password" required>
                </div>
            </div>
            <div class="row">
				<div class="col-4">
                    <input class="btn btn-primary float-right m-3 check" type="submit" value="Sign Up!">
                </div>
            </div>
        </form>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script>
		$('.check').click(function(){
				const username = $(".username").val();
				form;
				$(document).on("submit", "form", function(e){
					e.preventDefault();
					form = this;
					return  false;
				});
                $.post("project.controller.php", {'action': 'check-username', 'username': username}).done(function(data){
					if(data === "EXISTS"){
						alert('username is taken');
						$('.form').submit(function () {
							return false;
						});
					}else{
						form.submit();
					}
				}); 
            });
	</script>
</body>

</html>