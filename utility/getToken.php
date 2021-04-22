<?php
function getToken($conn){
	$token = bin2hex(random_bytes(64));
	
	$sql = "SELECT token FROM usertoken WHERE token LIKE '$token'";
	$result = $conn->query($sql);
	
	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
		$s_token = $row["token"];
	}
	
	if(!isset($s_token) || $s_token != $token){
		return $token;
	}else{
		return false;
	}
}
?>