<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();
setupDB($conn);

if(isset($_COOKIE["token"]) && $userId = getTokenUser($conn)){
	$_SESSION['userid'] = $userId;
	forgetLogin($conn, $_COOKIE["token"]);
}

if(!isset($_SESSION['userid'])){
	die(jsonMessage("not logged in"));
}

if(deleteUserAccount($conn, $_SESSION['userid'])){
	echo jsonMessage("account_deleted");
}

session_destroy();
echo jsonMessage("not logged in");

$conn->close();
?>
