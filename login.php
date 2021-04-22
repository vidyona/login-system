<?php
//error_reporting(0);
include_once("utility/getToken.php");

function getuserdata($conn, $s_user){
	$sql = "SELECT name, dob, country, favcolor FROM userdata WHERE userid LIKE '$s_user'";
	$result = $conn->query($sql);
		
	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
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
}else{
	die('{"loginStatus": "variables not set"}');
}

$conn = new mysqli("localhost", "root", "", "login");

$sql = "SELECT userid, password FROM userdata WHERE userid LIKE '$user'";
$result = $conn->query($sql);

if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	$s_user = $row['userid'];
	$s_pass = $row['password'];
}
	
if(!isset($s_user) || $user != $s_user){
	die('{"loginStatus":"usernotfound"}');
}

if(!isset($s_pass) || $pass != $s_pass){
	die('{"loginStatus":"incorrectpass"}');
}

echo getuserdata($conn, $s_user);
		
if($token = getToken($conn)){
	$sql = "insert into usertoken(userid, token) values('$user', '$token')";
	$conn->query($sql);

	setcookie("token", $token, time() + 3600, "/", false, false);
}else{
	echo '{"loginStatus":"token exists"}';
}

$conn->close();
?>