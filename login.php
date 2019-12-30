<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />

    <title>Login Page</title>

    <link rel='stylesheet' href='css/bootstrap.min.css' />
    <link rel='stylesheet' href='css/style.css' />
</head>

<body>
<div class="loginpage">
        <div class="image float-left">
            <img src="imgs/pm.jpg" alt="project_managers">
        </div>
        <form method="post" name="loginForm" onsubmit="return login()" action="Projects.php" class="float-left">
        <h2 class="header"> Project manager</h2>
        <div class="container col-md-pull-2  ">
            <h1>Login :</h1>

            <div class="row">
                <div class="col-lg-5 ">
                    <div class="label"> User Name </div>
                </div>

                <div class="col-lg-5 ">
                    <input type="text" name="userName">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5 ">
                    <div class="label"> Password </div>
                </div>

                <div class="col-lg-5 ">
                    <input type="password" name="password">
                </div>
            </div>
     
  
        <input class="btn btn-danger " type="submit" value="Login">
     </div>
    </form>
     <div class="float-fix"></div>
</div>    
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
