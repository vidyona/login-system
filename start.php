<?php
//error_reporting(0);

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];
	
	$localhost = "192.168.0.192:3306";
$adminUser = "root";
$adminPass = "root";

$conn = mysqli_connect($localhost, $adminUser, $adminPass) or die('{"loginStatus":"Couldn\'t connect"}');
	
	mysqli_select_db($conn, "login");

	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$ctoken'";
	
	$uid_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($uid_token)){
		$s_userid = $row["userid"];
		$s_token = $row["token"];
	}
	
	if($s_token == $ctoken){
		$query = "SELECT name, dob, country, favcolor FROM userdata WHERE userid LIKE '$s_userid'";
		$userdata = mysqli_query($conn, $query);
		
		if($row = mysqli_fetch_array($userdata)){
		$name = $row["name"];
		$dob = $row["dob"];
		$country = $row["country"];
		$favcolor = $row["favcolor"];
		}
	
		echo '{"loginStatus":"logged in", "name": "'.$name.'", "dob": "'.$dob.'", "country": "'.$country.'", "favcolor": "'.$favcolor.'"}';
	}else{
		echo '{"loginStatus":"log in"}';
	}
	
	mysqli_close($conn);
}else{
	echo '{"loginStatus":"log in"}';
}
?>
