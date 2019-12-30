<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

	<title>Login Page</title>

	<link rel='stylesheet' href='css/bootstrap.min.css' />
	<link rel='stylesheet' href='css/style.css' />
</head>

<body>
	<div class="container-fluid">
		<form method="post" name="loginForm" action="project.controller.php">
			<input type="hidden" name="action" value="login">
			<h1>Login</h1>
			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
					<div class="label"> Username: </div>
				</div>

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
					<input type="text" name="username">
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
					<div class="label"> Password: </div>
				</div>

				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
					<input type="password" name="password">
				</div>
			</div>
			
			<input class="btn btn-danger float-left  " type="submit" value="Login">
			<!--       using div no action -->
			<!--        <div class="btn btn-danger float-left  " onclick="login()"   >Login</div>-->
			
		</form>
	</div>
	<script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>


</html>
