<?php
//error_reporting(0);
require_once "utility.php";

$conn = openConnection();

$conn->query("USE $db_name");

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];
} else {
	die('{"loginStatus": "not logged in"}');
}
	
$sql = "DELETE FROM usertoken WHERE token LIKE '$clientToken'";
$conn->query($sql);

setcookie("token", "", 0, "/");
	
echo '{"loginStatus":"not logged in"}';

$conn->close();
?>