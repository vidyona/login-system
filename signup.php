<?php
//error_reporting(0);
function getToken($conn){
	$token = bin2hex(random_bytes(64));
	
	$query = "SELECT token FROM usertoken WHERE token LIKE '$token'";
	$s_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($s_token)){
		$s_token = $row["token"];
	}
	
	if($s_token != $token){
		return $token;
	}else{
		echo false;
	}
}

if(isset($_POST["username"]) && isset($_POST["password"])){
$user = $_POST["username"];
$pass = $_POST["password"];
}else{echo '{"loginStatus": "variables not set"}';}

$conn = mysqli_connect("localhost", "root") or die('{"loginStatus":"Couldn\'t connect"}');

mysqli_select_db($conn, "login");

$query = "SELECT userid FROM userdata WHERE userid LIKE '$user'";
$s_user = mysqli_query($conn, $query);

if($row = mysqli_fetch_array($s_user)){
	$s_user = $row["userid"];
}

if($s_user == $user){
	echo '{"loginStatus": "userExists"}';
}else{
	$query = "insert into userdata(userid, password) values('$user', '$pass')";
	mysqli_query($conn, $query);
	
	$token = getToken($conn);
	
	if($token){
		$query = "insert into usertoken(userid, token) values('$user', '$token')";
		mysqli_query($conn, $query);
		setcookie("token", $token, time() + 3600, "/");
	}else{
		echo '{"loginStatus":"token exists"}';
	}
	
	echo '{"loginStatus": "signed up"}';
}

mysqli_close($conn);
?>