<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <title>Login Page</title>

    <link rel='stylesheet' href='css/bootstrap.min.css' />
    <link rel='stylesheet' href='css/style.css' />
</head>

<body>
    <form method="post" name="loginForm" onsubmit="return login()" action="Projects.php">
        <div class="container">
            <h1>Login :</h1>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label"> User Name </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="text" name="userName">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="label"> Password </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <input type="password" name="password">
                </div>
            </div>
        </div>

        <input class="btn btn-danger float-left" type="submit" value="Login">

    </form>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/js.js"></script>
    <script>
        function login() {
            var userName = document.forms["loginForm"]["userName"].value;
            var password = document.forms["loginForm"]["password"].value;
            if (userName == "username" && password == "1234") {
                window.location.href = "Projects.php";
                return true;
            } else {
                alert("Wrong user name or Password");
                return false;

            }
        };
    </script>
</body>

</html>
