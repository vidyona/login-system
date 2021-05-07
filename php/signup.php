<?php
//error_reporting(0);
require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$userId = $_POST["username"];
	$pass = $_POST["password"];
}else{
	die(jsonMessage("variables not set"));
}

$conn = openConnection();
setupDB($conn);

if(doesUserExists($conn, $userId)){
	die(jsonMessage("userExists"));
}

echo jsonMessage("user does not exists");

$sql = "insert into userdata(userid, password) values('$userId', '$pass')";

if($conn->query($sql) === TRUE){
	$_SESSION['userid'] = $userId;

	if(!isset($_POST["rememberLogin"]) || $_POST["rememberLogin"] === "true"){
		rememberLogin($conn, $userId);
	}

	echo jsonMessage("signed up");
} else {
	die($conn->error);
}

$conn->close();
?>