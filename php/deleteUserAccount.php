<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();

$conn->query("USE $db_name");

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];
} else {
	die('{"message": "not logged in"}');
}

$userId = getTokenUser($conn, $clientToken);

if(isset($userId)){
    echo deleteUserAccount($conn, $userId);

    logOut($conn, $clientToken);

    echo '{"message":"not logged in"}';
}else {
    die('{"message":"not logged in"}');
}

$conn->close();
?>