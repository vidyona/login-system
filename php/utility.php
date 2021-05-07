<?php
session_start();

function openConnection(){
    define("host", "localhost");
    define("user", "root");
    define("pass", "password");

    $conn = new mysqli(host, user, pass);

    if($conn->connect_error){
        die(json_encode(array(
            'message'=>'Connection failed',
            'connect_error'=>$conn->connect_error,
            'connect_errno'=>$conn->connect_errno
        )));
    }

    return $conn;
}

function setupDB($conn){
    $db_name = "login";

    $sql = "CREATE DATABASE IF NOT EXISTS $db_name";
    
    if($conn->query($sql) === TRUE){
        if($conn->query("USE $db_name") !== TRUE){
            if($conn->error){
                die(json_encode(array(
                    'message'=>'Error selecting database',
                    'error'=>$conn->error,
                    'errno'=>$conn->errno
                )));
            }
        }
    } else {
        if($conn->error){
            die(json_encode(array(
                'message'=>'Error creating database',
                'error'=>$conn->error,
                'errno'=>$conn->errno
            )));
        }
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
        if($conn->error){
            die(json_encode(array(
                'message'=>'Error creating table',
                'error'=>$conn->error,
                'errno'=>$conn->errno
            )));
        }
    }

    $sql = "CREATE TABLE IF NOT EXISTS rememberedLogin(
        id INT(6) UNSIGNED AUTO_INCREMENT KEY,
        userid VARCHAR(30) NOT NULL,
        token VARCHAR(200) NOT NULL UNIQUE,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if($conn->query($sql) !== TRUE){
        if($conn->error){
            die(json_encode(array(
                'message'=>'Error creating table',
                'error'=>$conn->error,
                'errno'=>$conn->errorno
            )));
        }
    }
}

function jsonMessage($message){
    return json_encode(array('message'=>$message));
}

function getuserdata($conn, $userId){
    $sql = "SELECT userid, name, dob, country, favcolor, last_updated
    FROM userdata WHERE userid LIKE '$userId'";
	$result = $conn->query($sql);
		
	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
        echo jsonMessage("logged in") . json_encode($row);
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
        if($userId = $row["userid"]){
            return $userId;
        }
    }

    return false;
}

function rememberLogin($conn, $userId){
    if($token = generateToken($conn)){
        $sql = "insert into rememberedLogin(userid, token) values('$userId', '$token')";
    
        if($conn->query($sql) !== TRUE){
            die(jsonMessage("Error storing token: " . $conn->error));
        }
    
        setcookie("token", $token, time() + 3600, "/", "", true, true);
    }
}

function doesUserExists($conn, $userId){
    $sql = "SELECT userid FROM userdata WHERE userid LIKE '$userId'";
    $result = $conn->query($sql);

    if($conn->error){
        echo json_encode(array(
            'message'=>'Error finding user',
            'error'=>$conn->error,
            'errno'=>$conn->errno
        ));
    }

    if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	    return true;
    } else {
        return false;
    }
}

function forgetLogin($conn, $clientToken){
    $sql = "DELETE FROM rememberedLogin WHERE token LIKE '$clientToken'";
    $success = $conn->query($sql);

	setcookie("token", "", 0, "/");

    return $success;
}

function deleteUserAccount($conn, $userId){
    $sql = "DELETE FROM userdata WHERE userid LIKE '$userId'";
    return $conn->query($sql);
}
?>