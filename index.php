<?php
//error_reporting(0);

require_once "php/utility.php";

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];
} else {
	header("Location: /login.html");
    exit;
}
	
$conn = openConnection();

setupDB($conn);

if($s_userId = getTokenUser($conn, $clientToken)){
    header("Location: /userdata.html");
    exit;
}else {
    header("Location: /login.html");
    exit;
}
	
$conn->close();
?>