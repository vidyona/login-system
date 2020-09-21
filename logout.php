<?php
//error_reporting(0);

include("token.php");
include("mysqli_config.php");
include("library.php");

$conn = new mysqli($localhost, $adminUser, $adminPass);

mysqli_select_db($conn, "login");

if(isset($_COOKIE["token"])){
	$c_token = $_COOKIE["token"];
	
	$query = "DELETE FROM usertoken WHERE token LIKE '$c_token'";
	$conn->query($query);
	setcookie("token", "", 0, "/");
	
	echo message("logged out");
}else{
	echo message("logged out");
}

$conn->close();
?>
