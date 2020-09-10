<?php
//error_reporting(0);

include("token.php");
include("mysqli_config.php");

$conn = mysqli_connect($localhost, $adminUser, $adminPass);

mysqli_select_db($conn, "login");

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];
	
	$query = "DELETE FROM usertoken WHERE token LIKE '$ctoken'";
	mysqli_query($conn, $query);
	setcookie("token", "", 0, "/");
	
	echo '{"message":"logged out"}';
}else{
	echo '{"message":"logged out"}';
}



mysqli_close($conn);
?>
