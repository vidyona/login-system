<?php
//error_reporting(0);

require_once "utility.php";

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];
} else {
	die('{"loginStatus": "not logged in"}');
}
	
$conn = openConnection();

setupDB($conn);

$userId = getTokenUser($conn, $clientToken);

if(isset($userId)){
    echo getuserdata($conn, $userId);
}else {
    die('{"loginStatus":"not logged in"}');
}
	
$conn->close();
?>