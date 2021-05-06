<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();
setupDB($conn);

if(isset($_SESSION['userid'])){
    echo "\nsession\n";
    echo getuserdata($conn, $_SESSION['userid']);
} else if(isset($_COOKIE["token"]) && $userId = getTokenUser($conn)){
    echo "\ncookie\n";
    echo getuserdata($conn, $userId);
    $_SESSION['userid'] = $userId;
} else {
	die('{"message": "not logged in"}');
}
	
$conn->close();
?>