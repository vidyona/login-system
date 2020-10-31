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

function setToken($conn, $user){
    $token = getToken($conn);
    
    if($token){
        $query = "insert into usertoken(userid, token) values('$user', '$token')";
	    mysqli_query($conn, $query);
        setcookie("token", $token, time() + 3600, "/", false, false);
    }else{
        echo '{"message":"token exists"}';
	}
	
	tokenCleanUp($conn);
}

function tokenCleanUp($conn){
	$query = "DELETE FROM usertoken WHERE TIMESTAMPDIFF(MINUTE, time, CURRENT_TIMESTAMP) > 60";
	mysqli_query($conn, $query);

	echo '{"message":"token cleaned up"}';
}
?>