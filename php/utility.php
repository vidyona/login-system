<?php
session_start();
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

function jsonMessage($message){
    return json_encode(array('message'=>$message));
}

function getuserdata($conn, $userId){
    if(isset($_SESSION['userid'])){
        $userId = $_SESSION['userid'];
    }

	$sql = "SELECT userid, name, dob, country, favcolor, last_updated FROM userdata WHERE userid LIKE '$userId'";
	$result = $conn->query($sql);
		
	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
        echo jsonMessage("logged in") . json_encode($row);
        echo "here";
	} else {
        return false;
    }
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

function getTokenUser($conn){
    $clientToken = $_COOKIE["token"];
    $sql = "SELECT userid FROM rememberedLogin
    WHERE token LIKE '$clientToken'";
	
    $result = $conn->query($sql);
	
    if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
        echo "php-util-98";
        if($userId = $row["userid"]){
            return $userId;
        }
    }

    return false;
}

function storeUserToken($conn, $userId){
    if($token = generateToken($conn)){
        $sql = "insert into rememberedLogin(userid, token) values('$userId', '$token')";
    
        if($conn->query($sql) !== TRUE){
            die("Error storing token: " . $conn->error);
        }
    
        setcookie("token", $token, time() + 3600, "/", "", true, true);
    }
}

function doesUserExists($conn, $userId){
    $sql = "SELECT userid FROM userdata WHERE userid LIKE '$userId'";

    $result = $conn->query($sql);

    if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	    return true;
    } else {
        return false;
    }
}

function logOut($conn, $clientToken){
    $sql = "DELETE FROM rememberedLogin WHERE token LIKE '$clientToken'";
	$conn->query($sql);

	session_destroy();
	setcookie("token", "", 0, "/");
}

function deleteUserAccount($conn, $userId){
    $sql = "DELETE FROM userdata WHERE userid LIKE '$userId'";
    $conn->query($sql);
}
?>