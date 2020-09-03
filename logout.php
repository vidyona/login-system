<?php
//error_reporting(0);

$localhost = "192.168.0.192:3306";
$adminUser = "root";
$adminPass = "root";

$conn = mysqli_connect($localhost, $adminUser, $adminPass);

mysqli_select_db($conn, "login");

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];
	
	$query = "DELETE FROM usertoken WHERE token LIKE '$ctoken'";
	mysqli_query($conn, $query);
	setcookie("token", "", 0, "/");
	
	echo '{"loginStatus":"logged out"}';
}else{
	echo '{"loginStatus":"logged out"}';
}

mysqli_close($conn);
?>
