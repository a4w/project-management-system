<?php

const DB_HOST = '127.0.0.1';
const DB_USER = 'root';
const DB_PASSWORD = '12341234';
const DB_NAME = 'project-management-system';



$link = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


    $name = $_POST["Name"];
	$StartDate = $_POST["StartDate"];
	$EndDate = $_POST["EndDate"];
	$Cost = $_POST["Cost"];
	$HoursperDay = $_POST["HoursperDay"];
	$Members = $_POST["Members"];
	$sql = "INSERT INTO project (name, `hours-per-day`, cost , 	`start-date` , 	`end-date`) VALUES ('$name','$HoursperDay', '$Cost', '$StartDate', '$EndDate')";

if ($link->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $link->error;
}


	mysqli_close($link);
?>