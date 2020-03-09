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

function getuserdata($conn, $s_user){
	$query = "SELECT name, dob, country, favcolor FROM userdata WHERE userid LIKE '$s_user'";
	$userdata = mysqli_query($conn, $query);
		
	if($row = mysqli_fetch_array($userdata)){
		$name = $row["name"];
		$dob = $row["dob"];
		$country = $row["country"];
		$favcolor = $row["favcolor"];
	}
		return '{"loginStatus":"logged in", "name": "'.$name.'", "dob": "'.$dob.'", "country": "'.$country.'", "favcolor": "'.$favcolor.'"}';
}

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = $_POST["username"];
	$pass = $_POST["password"];
}else{echo '{"loginStatus": "variables not set"}';}

$conn = mysqli_connect("localhost", "root");
mysqli_select_db($conn, "login");

$sql = "SELECT userid, password FROM userdata WHERE userid LIKE '$user'";
$uid_pass = mysqli_query($conn, $sql);

if($row = mysqli_fetch_array($uid_pass)){
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
	
		echo getuserdata($conn, $s_user);

	}else if($user != "Vishesh" || $pass != "secret"){
		echo '{"loginStatus":"incorrectpass"}';
	}
}else{
	echo '{"loginStatus":"usernotfound"}';
}

mysqli_close($conn);
?>