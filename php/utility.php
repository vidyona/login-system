<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => null,
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
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
  $stmt = $conn->prepare("SELECT userid, name, dob, country, favcolor, last_updated
  FROM userdata WHERE userid LIKE ?");

  $stmt->bind_param("s", $userId);
	$stmt->execute();

  $result = $stmt->get_result();

	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
      echo jsonMessage("logged in") . json_encode($row);
	} else {
      return false;
  }
}

function generateToken($conn){
	$token = bin2hex(random_bytes(16));

	$stmt = $conn->prepare("SELECT token FROM rememberedLogin WHERE token LIKE ?");
  $stmt->bind_param("s", $token);
  $stmt->execute();

	$result = $stmt->get_result();

	if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
		$s_token = $row["token"];
	}

	if(!isset($row["token"]) || $row["token"] != $token){
		return $token;
	}else{
		return false;
	}
}

function getTokenUser($conn){
    $clientToken = $_COOKIE["token"];
    $stmt = $conn->prepare("SELECT userid FROM rememberedLogin
    WHERE token LIKE ?");
    $stmt->bind_param("s", $clientToken);
    $stmt->execute();

    $result = $stmt->get_result();

    if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
        if($userId = $row["userid"]){
            return $userId;
        }
    }

    return false;
}

function rememberLogin($conn, $userId){
    if($token = generateToken($conn)){
        $stmt = $conn->prepare("insert into rememberedLogin(userid, token) values(?, ?)");

        $stmt->bind_param("ss", $userId, $token);
        $stmt->execute();

        if($stmt->error){
            die(jsonMessage("Error remembering User: " . $stmt->error));
        }

        setcookie("token", $token, [
            'expires' => time() + 86400,
            'path' => '/',
            'domain' => null,
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);
    }
}

function doesUserExists($conn, $userId){
    $stmt = $conn->prepare("SELECT userid FROM userdata WHERE userid LIKE ?");
    $stmt->bind_param("s", $userId);

    $stmt->execute();

    $result = $stmt->get_result();

    if($stmt->error){
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
    $stmt = $conn->prepare("DELETE FROM rememberedLogin WHERE token LIKE ?");
    $stmt->bind_param("s", $clientToken);
    $stmt->execute();

    setcookie("token", "", 0, "/");
}

function deleteUserAccount($conn, $userId){
    $stmt = $conn->prepare("DELETE FROM userdata WHERE userid LIKE ?");
    $stmt->bind_param("s", $userId);

    return $stmt->execute();
}

function validateUserInput($input){
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

function validateIdPass($input){
    if (!preg_match("/^[a-zA-Z0-9-_. ]*$/",$input)) {
        echo jsonMessage("Only a-z A-Z 0-9 '-' '_' and '.' are allowed");
    }
}
?>
