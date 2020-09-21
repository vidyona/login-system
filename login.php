<?php
header('Content-Type: application/json');

//error_reporting(0);
include("token.php");
include("mysqli_config.php");
include("classes.php");
include("getUserData.php");

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = $_POST["username"];
	$pass = $_POST["password"];
}else{echo message("variables not set");}

$conn = mysqli_connect($localhost, $adminUser, $adminPass);

mysqli_select_db($conn, "login");

$sql = "SELECT userid, password FROM userdata WHERE userid LIKE '$user'";
$uid_pass = mysqli_query($conn, $sql);


if($uid_pass && $row = mysqli_fetch_array($uid_pass)){
	$s_user = $row['userid'];
	$s_pass = $row['password'];
}

if(isset($s_user) && $user == $s_user){
	if($pass == $s_pass){
		setToken($conn, $user);
		
		$userData = getuserdata($conn, $s_user);

		if($userData){
			echo json_encode($userData);
		}

	}else if($pass != $s_pass){
		echo message("incorrectpass");
	}
}else{
	echo message("usernotfound");
}

mysqli_close($conn);
?>
