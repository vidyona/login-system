<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();
setupDB();

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];

	$userId = getTokenUser($conn, $clientToken);
} else {
	die(jsonMessage("not logged in"));
}

if(isset($userId)){
    echo deleteUserAccount($conn, $userId);

    forgetLogin($conn, $clientToken);

    echo jsonMessage("not logged in");
}else {
    die(jsonMessage("not logged in"));
}

$conn->close();
?>