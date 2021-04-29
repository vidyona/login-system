<?php
$db_name = "login";

function openConnection(){
    $host = "localhost";
    $user = "root";
    $pass = "password";

    $conn = new mysqli($host, $user, $pass);

    if($conn->connect_error){
	    die("Connection failed: " . $conn->connect_error . ", errno: " . $conn->connect_errno);
    }

    return $conn;
}

function setupDB($conn){
    $sql = "CREATE DATABASE IF NOT EXISTS login";

    if($conn->query($sql) === TRUE){
        $conn->query("USE login");
    } else {
        die("Error creating database: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS userdata(
        id INT(6) UNSIGNED AUTO_INCREMENT KEY,
        userid VARCHAR(30) NOT NULL UNIQUE,
        password VARCHAR(30) NOT NULL,
        name VARCHAR(30) NULL,
        dob DATE,
        country VARCHAR(30) NULL,
        favcolor VARCHAR(30) NULL,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if($conn->query($sql) !== TRUE){
        die("Error creating table: " . $conn->error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS rememberedLogin(
        id INT(6) UNSIGNED AUTO_INCREMENT KEY,
        userid VARCHAR(30) NOT NULL,
        token VARCHAR(200) NOT NULL UNIQUE,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if($conn->query($sql) !== TRUE){
        echo "Error creating table: " . $conn->error;
    }
}

function getuserdata($conn, $s_user){
	$sql = "SELECT name, dob, country, favcolor FROM userdata WHERE userid LIKE '$s_user'";
	$result = $conn->query($sql);
		
	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
		$name = $row["name"];
		$dob = $row["dob"];
		$country = $row["country"];
		$favcolor = $row["favcolor"];
	} else {
        return false;
    }

	return '{"loginStatus":"logged in", "name": "'.$name.'", "dob": "'.$dob.'", "country": "'.$country.'", "favcolor": "'.$favcolor.'"}';
}

function generateToken($conn){
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

function getTokenUser($conn, $clientToken){
    $sql = "SELECT userid FROM rememberedLogin
    WHERE token LIKE '$clientToken'";
	
    $result = $conn->query($sql);
	
    if($result && $result->num_rows > 0
    && $row = $result->fetch_assoc()){
        if($s_userid = $row["userid"]){
            return $s_userid;
        }
    }

    return false;
}
?>