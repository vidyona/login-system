<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();
setupDB($conn);

if(isset($_COOKIE["token"]) && $userId = getTokenUser($conn)){
	$_SESSION['userid'] = $userId;
}

if(isset($_SESSION['userid'])){
  if($userData = getuserdata($conn, $_SESSION['userid'])){
    echo $userData;
  }
} else {
	die(jsonMessage("not logged in"));
}

$conn->close();
?>
