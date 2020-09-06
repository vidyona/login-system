<?php
function getToken($conn){
	$token = bin2hex(random_bytes(64));
	
	$query = "SELECT token FROM usertoken WHERE token LIKE '$token'";
	$s_token = mysqli_query($conn, $query);
	
	if($row = mysqli_fetch_array($s_token)){
		$s_token = $row["token"];
	}
	
	if($s_token != $token){
		return $token;
	}else{
		echo false;
	}
}
?>