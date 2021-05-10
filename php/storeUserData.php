<?php
require_once "utility.php";

function validateDate($date){
	if(isset($date)){
		$d = DateTime::createFromFormat("Y-m-d", $date);

		if($d && $d->format("Y-m-d") == $date){
			return $d->format("Y-m-d");
		}
	}

	return false;
}

if(isset($_POST["name"])
&& isset($_POST["country"])
&& isset($_POST["favcolor"])){
	$name = validateUserInput($_POST["name"]);
	$dob = validateDate($_POST["dob"]);
	$country = validateUserInput($_POST["country"]);
	$favcolor = $_POST["favcolor"];
}else{
	die(jsonMessage("variables not set"));
}

$conn = openConnection();
setupDB($conn);

if(isset($_COOKIE["token"]) && $userId = getTokenUser($conn)){
	$_SESSION['userid'] = $userId;
}

if(!isset($_SESSION['userid'])){
    die(jsonMessage("not logged in"));
}

$userId = $_SESSION['userid'];

$sql = "UPDATE userdata SET name = '$name', country = '$country', favcolor = '$favcolor' WHERE userid LIKE '$userId'";

if($conn->query($sql) === TRUE){
	echo jsonMessage("dataUpdated");
} else {
	echo jsonMessage("Error updating data: " . $conn->error);
}

if($dob){
	if($conn->query("UPDATE userdata SET dob = '$dob' WHERE userid LIKE '$userId'") !== TRUE){
		echo jsonMessage($conn->error);
	}
}

$conn->close();
?>