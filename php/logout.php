<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();
setupDB($conn);

session_destroy();

if(isset($_COOKIE["token"])){
	forgetLogin($conn, $_COOKIE["token"]);

	echo jsonMessage("not logged in");
} else {
	die(jsonMessage("not logged in"));
}

$conn->close();
?>