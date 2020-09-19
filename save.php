<?php
include("mysqli_config.php");
include("library.php");

if(isset($_POST["userdata"])){
	$userData = json_decode($_POST["userdata"]);
}else{
	die('{"message": "variables not set"}');
}

//check if the matched token has userid in userdata too

if(isset($_COOKIE["token"])){
	$c_token = $_COOKIE["token"];

	$conn = new mysqli($localhost, $adminUser, $adminPass);

	mysqli_select_db($conn, "login");

	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$c_token'";
	
	$uid_and_token = $conn->query($query);
	
	if($row = mysqli_fetch_array($uid_and_token)){
		$s_uid = $row["userid"];
		$s_token = $row["token"];
	}

	if(isset($s_uid) && isset($s_token)){
		$query = "SELECT userid FROM userdata WHERE userid LIKE '$s_uid'";

		$userdata_userid = $conn->query($query);

		if($row = mysqli_fetch_array($userdata_userid)){
			$userdata_userid = $row["userid"];
		}
	}
	
	if(isset($userdata_userid) && ($s_token == $c_token)){
		$query = "UPDATE userdata
		SET name = '$userData->name',
			dob = '$userData->dob',
			country = '$userData->country',
			favcolor = '$userData->favcolor'
			WHERE userid LIKE '$s_uid'";

		$updated = mysqli_query($conn, $query);
	}
}

mysqli_close($conn);
?>
