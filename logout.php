<?php
//error_reporting(0);

$conn = new mysqli("localhost", "root", "", "login");

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];
	
	$sql = "DELETE FROM usertoken WHERE token LIKE '$ctoken'";
	$conn->query($sql);

	setcookie("token", "", 0, "/");
	
	echo '{"loginStatus":"logged out"}';
}else{
	echo '{"loginStatus":"logged out"}';
}

$conn->close();
?>