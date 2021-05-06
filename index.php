<?php
//error_reporting(0);
session_start();

require_once "php/utility.php";

$conn = openConnection();
setupDB($conn);

if(isset($_SESSION['userid'])){
    header("Location: /userdata.html");
    exit;
} else if(isset($_COOKIE["token"]) && $s_userId = getTokenUser($conn)){
    header("Location: /userdata.html");
    exit;
} else {
	header("Location: /login.html");
    exit;
}
	
$conn->close();
?>