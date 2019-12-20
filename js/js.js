
var deliverables = Array();
function addDeliverables(){
    deliverables.push(document.forms["add_project"]["deliverables"].value);
    document.forms["add_project"]["deliverables"].value = "";
};

function login(){
	var userName = document.forms["loginForm"]["userName"].value;
	var password = document.forms["loginForm"]["password"].value;
	if(userName == "username" && password == "1234"){
        window.location.href="Projects.php";
        return true;
    }
	else{
		alert("Wrong user name or Password");
        return false;
		
	}
};

