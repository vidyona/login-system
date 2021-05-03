<?php
//error_reporting(0);

require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = $_POST["username"];
	$pass = $_POST["password"];
}else{
	die('{"message": "variables not set"}');
}

$conn = openConnection();

$conn->query("USE $db_name");

if(!doesUserExists($conn, $user)){
	die('{"message":"usernotfound"}');
}

$sql = "SELECT userid, password FROM userdata
WHERE userid LIKE '$user' AND password LIKE '$pass'";

$result = $conn->query($sql);

if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	echo jsonMessage("logged in");
} else {
	die('{"message":"incorrectpass"}');
}
		
if($token = generateToken($conn)){
	$sql = "insert into rememberedLogin(userid, token) values('$user', '$token')";
	$conn->query($sql);

	setcookie("token", $token, time() + 3600, "/", "", true, true);
}else{
	echo '{"message":"token exists"}';
}

$conn->close();
?>