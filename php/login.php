<?php
//error_reporting(0);

require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = validateIdPass(validateUserInput($_POST["username"]));
	$pass = validateIdPass(validateUserInput($_POST["password"]));
}else{
	die(jsonMessage("variables not set"));
}

$conn = openConnection();
setupDB($conn);

if(!doesUserExists($conn, $user)){
	die(jsonMessage("usernotfound"));
}

$sql = "SELECT userid, password FROM userdata
WHERE userid LIKE '$user' AND password LIKE '$pass'";
$result = $conn->query($sql);

if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	$_SESSION['userid'] = $row['userid'];

	if(!isset($_POST["rememberLogin"]) || $_POST["rememberLogin"] === "true"){
		echo $_POST["rememberLogin"];
		rememberLogin($conn, $user);
	}

	echo jsonMessage("logged in");
} else {
	die(jsonMessage("incorrectpass"));
}

$conn->close();
?>