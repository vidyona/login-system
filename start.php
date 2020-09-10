<?php
//error_reporting(0);
include("mysqli_config.php");
include("classes.php");
include("getUserData.php");

if(isset($_COOKIE["token"])){
	$ctoken = $_COOKIE["token"];

	$conn = mysqli_connect($localhost, $adminUser, $adminPass) or die('{"message":"Couldn\'t connect"}');
	
	mysqli_select_db($conn, "login");

	$query = "SELECT userid, token FROM usertoken WHERE token LIKE '$ctoken'";
	
	$uid_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($uid_token)){
		$s_userid = $row["userid"];
		$s_token = $row["token"];
	}
	
	if(isset($s_userid) && isset($s_token) && $s_token == $ctoken){
		$userData = getuserdata($conn, $s_userid);

		if($userData){
			echo json_encode($userData);
		}
	}else{
		echo '{"message":"log in"}';
	}
	
	mysqli_close($conn);
}else{
	echo '{"message":"log in"}';
}
?>
