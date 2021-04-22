<?php
//error_reporting(0);

include("utility/setupDB.php");

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

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];
}else{
	die('{"loginStatus":"variables not set"}');
}
	
$conn = new mysqli("localhost", "root");

if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error . ", errno: " . $conn->connect_errno);
}

setupDB($conn);

$sql = "SELECT userid, token FROM usertoken WHERE token LIKE '$ctoken'";
	
$result = $conn->query($sql);
	
if($result && $result->num_rows > 0){
	if($row = $result->fetch_assoc()){
		$s_userid = $row["userid"];
		$s_token = $row["token"];
	}
}
	
if($s_token == $ctoken){
	echo getuserdata($conn, $s_userid);
}else{
	echo '{"loginStatus":"log in"}';
}
	
$conn->close();
?>