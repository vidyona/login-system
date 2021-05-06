<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();

$conn->query("USE $db_name");

session_destroy();

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];

	logOut($conn, $clientToken);

	echo '{"message":"not logged in"}';
} else {
	die('{"message": "not logged in"}');
}

$conn->close();
?>