<?php
include("mysqli_config.php");
include("library.php");
include("dateTime.php");

function validate_token($conn, $c_token){
	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$c_token'";
	
	$t_uid_and_token = $conn->query($query);

	if($row = mysqli_fetch_array($t_uid_and_token)){
		$t_uid = $row["userid"];
		$s_token = $row["token"];
	}

	if(isset($t_uid) && isset($s_token)){
		$query = "SELECT userid FROM userdata WHERE userid LIKE '$t_uid'";

		$d_uid = $conn->query($query);

		if($row = mysqli_fetch_array($d_uid)){
			$d_uid = $row["userid"];
		}
	}

	if(isset($d_uid) && ($s_token == $c_token)){
		return $d_uid;
	}

	return false;
}

if(isset($_POST["userdata"])){
	$userData = json_decode($_POST["userdata"]);
}else{
	die(message("variables not set"));
}

if(isset($_COOKIE["token"])){
	$conn = new mysqli($localhost, $adminUser, $adminPass);
	mysqli_select_db($conn, "login");

	$c_token = $_COOKIE["token"];

	$d_uid = validate_token($conn, $c_token);
	
	if($d_uid){
		$query = "UPDATE userdata
		SET name = '$userData->name',
			dob = '$userData->dob',
			country = '$userData->country',
			favcolor = '$userData->favcolor'
			WHERE userid LIKE '$d_uid'";

		$updated = $conn->query($query);
	}

	$conn->close();
}
?>
