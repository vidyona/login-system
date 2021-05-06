<?php
//error_reporting(0);
require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$userId = $_POST["username"];
	$pass = $_POST["password"];
}else{
	die('{"message": "variables not set"}');
}

$conn = openConnection();

setupDB($conn);

if(doesUserExists($conn, $userId)){
	die('{"message": "userExists"}');
}

echo '{"message": "user does not exists"}';

$sql = "insert into userdata(userid, password) values('$userId', '$pass')";

if($conn->query($sql) === TRUE){
	echo '{"message": "signed up"}';
	$_SESSION['userid'] = $userId;
} else {
	die($conn->error);
}
	
storeUserToken($conn, $userId);

$conn->close();
?>