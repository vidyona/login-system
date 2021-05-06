<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();

$conn->query("USE $db_name");

session_destroy();

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];

	$sql = "DELETE FROM rememberedLogin WHERE token LIKE '$clientToken'";
	$conn->query($sql);
} else {
	die('{"message": "not logged in"}');
}

setcookie("token", "", 0, "/");
	
echo '{"message":"not logged in"}';

$conn->close();
?>