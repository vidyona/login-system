<?php
//error_reporting(0);
include("token.php");
include("mysqli_config.php");

if(isset($_POST["username"]) && isset($_POST["password"])){
$user = $_POST["username"];
$pass = $_POST["password"];
}else{echo '{"message": "variables not set"}';}

$conn = mysqli_connect($localhost, $adminUser, $adminPass) or die('{"message":"Couldn\'t connect"}');

mysqli_select_db($conn, "login");

$query = "SELECT userid FROM userdata WHERE userid LIKE '$user'";
$s_user = mysqli_query($conn, $query);

if($row = mysqli_fetch_array($s_user)){
	$s_user = $row["userid"];
}

if($s_user == $user){
	echo '{"message": "userExists"}';
}else{
	$query = "insert into userdata(userid, password) values('$user', '$pass')";
	mysqli_query($conn, $query);
	
	setToken($conn, $user);
	
	echo '{"message": "signed up"}';
}

mysqli_close($conn);
?>
