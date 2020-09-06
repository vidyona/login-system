<?php
include("mysqli_config.php");

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

	$conn = mysqli_connect($localhost, $adminUser, $adminPass) or die('{"loginStatus":"Couldn\'t connect"}');

	mysqli_select_db($conn, "login");

	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$c_token'";
	
	$uid_and_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($uid_and_token)){
		$s_uid = $row["userid"];
		$s_token = $row["token"];
	}
	
	if($s_token == $c_token){
		$query = "UPDATE userdata SET name = '$name',
			dob = '$dob',
			country = '$country',
			favcolor = '$favcolor' WHERE userid LIKE '$s_uid'";
		mysqli_query($conn, $query);
		
		echo '{"loginStatus": "dataUpdated"}';
	}
}

mysqli_close($conn);
?>
