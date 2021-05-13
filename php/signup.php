<?php
//error_reporting(0);
require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$userId = validateUserInput($_POST["username"]);
	$pass = validateUserInput($_POST["password"]);
}else{
	die(jsonMessage("variables not set"));
}

$conn = openConnection();
setupDB($conn);

if(doesUserExists($conn, $userId)){
	die(jsonMessage("userExists"));
}

echo jsonMessage("user does not exists");

$stmt = $conn->prepare("insert into userdata(userid, password) values(?, ?)");

$stmt->bind_param("ss", $userId, $pass);

if($stmt->execute()){
	$_SESSION['userid'] = $userId;

	if(!isset($_POST["rememberLogin"]) || $_POST["rememberLogin"] === "true"){
		rememberLogin($conn, $userId);
	}

	echo jsonMessage("signed up");
} else {
	die(jsonMessage($conn->error));
}

$conn->close();
?>
