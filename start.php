<?php
//error_reporting(0);
include("mysqli_config.php");
include("classes.php");
include("getUserData.php");
include("dbSetup.php");
include("library.php");

$conn = new mysqli($localhost, $adminUser, $adminPass);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

db_setup($conn);

message($conn->error);

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];

	$query = "SELECT userid, token
	FROM usertoken
	WHERE token
	LIKE '$ctoken'";
	
	$uid_token = $conn->query($query);
	
	if($uid_token && $row = mysqli_fetch_array($uid_token)){
		$s_userid = $row["userid"];
		$s_token = $row["token"];
	}
	
	if(isset($s_userid) && isset($s_token) && $s_token == $ctoken){
		$userData = getuserdata($conn, $s_userid);

		if($userData){
			echo json_encode($userData);
		} else {
			message("log in");
		}
	}else{
		message("log in");
	}
	
	
}else{
	message("log in");
}

$conn->close();
?>
