function login(){
	var userName = document.forms["loginForm"]["userName"].value;
	var password = document.forms["loginForm"]["password"].value;
	if(userName == "userName" && password == "password"){
		return true;
	}
	else{
		alert("Wrong user name or Password");
		return false;
	}
};