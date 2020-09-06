<?php
header('Content-Type: application/json');

//error_reporting(0);
include("token.php");
include("mysqli_config.php");
include("classes.php");

function getuserdata($conn, $s_user){
	$query = "SELECT name, dob, country, favcolor FROM userdata WHERE userid LIKE '$s_user'";
	$userdataQ = mysqli_query($conn, $query);
		
	if($row = mysqli_fetch_array($userdataQ)){
		$loginStatus = "logged in";
		$name = $row["name"];
		$dob = $row["dob"];
		$country = $row["country"];
		$favcolor = $row["favcolor"];

		$userData = new UserData();

		$userData->loginStatus = $loginStatus;
		$userData->name = $name;
		$userData->dob = $dob;
		$userData->country = $country;
		$userData->favcolor = $favcolor;

		return $userData;
	} else {
		return $row;
	}
}

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = $_POST["username"];
	$pass = $_POST["password"];
}else{echo '{"loginStatus": "variables not set"}';}

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
		$token = getToken($conn);
	
		if($token){
			$query = "insert into usertoken(userid, token) values('$user', '$token')";
			mysqli_query($conn, $query);
			setcookie("token", $token, time() + 3600, "/", false, false);
		}else{
			echo '{"loginStatus":"token exists"}';
		}
		
		$userData = getuserdata($conn, $s_user);

		if($userData){
			echo json_encode($userData);
		}

	}else if($pass != $s_pass){
		echo '{"loginStatus":"incorrectpass"}';
	}
}else{
	echo '{"loginStatus":"usernotfound"}';
}

mysqli_close($conn);
?>
