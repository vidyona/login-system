<?php
if(isset($_POST["name"])
&& isset($_POST["dob"])
&& isset($_POST["country"])
&& isset($_POST["favcolor"])){
	$name = $_POST["name"];
	$dob = $_POST["dob"];
	$country = $_POST["country"];
	$favcolor = $_POST["favcolor"];
}else{
	echo '{"loginStatus": "variables not set"}';
}

if(isset($_COOKIE["token"])){
	$c_token = $_COOKIE["token"];
} else {
	die('{"loginStatus": "log in"}');
}

$conn = new mysqli("localhost", "root", "", "login");

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error . ", errno: " . $conn->connect_errno);
}

$sql = "SELECT userid, token FROM usertoken WHERE token LIKE '$c_token'";
$result = $conn->query($sql);
	
if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	$s_uid = $row["userid"];
	$s_token = $row["token"];
}

if($s_token == $c_token){
	$sql = "UPDATE userdata SET name = '$name', dob = '$dob', country = '$country', favcolor = '$favcolor' WHERE userid LIKE '$s_uid'";
	
	if($conn->query($sql)){
		echo '{"loginStatus": "dataUpdated"}';
	} else {
		die($conn->error);
	}
}

$conn->close();
?>