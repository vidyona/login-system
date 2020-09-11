<?php
include("mysqli_config.php");

if(isset($_POST["userdata"])){
	$userData = json_decode($_POST["userdata"]);
}else{
	die('{"message": "variables not set"}');
}

if(isset($_COOKIE["token"])){
	$c_token = $_COOKIE["token"];

	$conn = mysqli_connect($localhost, $adminUser, $adminPass) or die('{"message":"Couldn\'t connect"}');

	mysqli_select_db($conn, "login");

	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$c_token'";
	
	$uid_and_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($uid_and_token)){
		$s_uid = $row["userid"];
		$s_token = $row["token"];
	}
	
	if($s_token == $c_token){
		$query = "UPDATE userdata
		SET name = '$userData->name',
			dob = '$userData->dob',
			country = '$userData->country',
			favcolor = '$userData->favcolor'
			WHERE userid LIKE '$s_uid'";

		$updated = mysqli_query($conn, $query);

		echo '{"message": "dataUpdated"}';
		echo '{"message": "' . $updated . '"}';
	}
}

mysqli_close($conn);
?>
