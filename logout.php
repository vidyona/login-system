<?php
//error_reporting(0);

$conn = mysqli_connect("localhost", "root");

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