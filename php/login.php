<?php
//error_reporting(0);

require_once "utility.php";

if(isset($_POST["username"]) && isset($_POST["password"])){
	$user = validateUserInput($_POST["username"]);
	$pass = validateUserInput($_POST["password"]);
}else{
	die(jsonMessage("variables not set"));
}

$conn = openConnection();
setupDB($conn);

if(!doesUserExists($conn, $user)){
	die(jsonMessage("usernotfound"));
}

$stmt = $conn->prepare("SELECT userid, password FROM userdata
WHERE userid LIKE ? AND password LIKE ?");

$stmt->bind_param("ss", $user, $pass);
$stmt->execute();

$result = $stmt->get_result();

if($result && $result->num_rows > 0 && $row = $result->fetch_assoc()){
	$_SESSION['userid'] = $row['userid'];

	if(!isset($_POST["rememberLogin"]) || $_POST["rememberLogin"] === "true"){
		rememberLogin($conn, $user);
	}

	echo jsonMessage("logged in");
} else {
	die(jsonMessage("incorrectpass"));
}

$conn->close();
?>
