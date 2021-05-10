<?php
require_once "utility.php";

function validateName($name){
	if(isset($name)){
		$name = validateUserInput($name);

		if (preg_match("/^[a-zA-Z0-9- ]*$/",$name)) {
        	return $name;
    	}
	}

	return false;
}

function validateDate($date){
	if(isset($date)){
		$d = DateTime::createFromFormat("Y-m-d", $date);

		if($d && $d->format("Y-m-d") == $date){
			return $d->format("Y-m-d");
		}
	}

	return false;
}

function validateCountry($country){
	if(isset($country)){
		return validateUserInput($country);
	}
	
	return false;
}

$name = validateName($_POST["name"]);
$dob = validateDate($_POST["dob"]);
$country = validateUserInput($_POST["country"]);
$favcolor = $_POST["favcolor"];

$conn = openConnection();
setupDB($conn);

if(isset($_COOKIE["token"]) && $userId = getTokenUser($conn)){
	$_SESSION['userid'] = $userId;
}

if(!isset($_SESSION['userid'])){
    die(jsonMessage("not logged in"));
}

$userId = $_SESSION['userid'];

$userdata = array(
	'name' => $name,
	'dob' => $dob,
	'country' => $country,
	'favcolor' => $favcolor
);

foreach ($userdata as $key => $value) {
	if(!$value){
		echo jsonMessage("skipping '$key'");
		continue;
	}

	$stmt = $conn->prepare("UPDATE userdata SET $key = ? WHERE userid LIKE ?");
	$stmt->bind_param("ss", $value, $userId);

	if($stmt->execute()){
		echo jsonMessage("dataUpdated");
	} else {
		echo jsonMessage("Error updating data: " . $stmt->error);
	}

	// $sql = "UPDATE userdata SET $key = '$value' WHERE userid LIKE '$userId'";

	// if($conn->query($sql) === TRUE){
	// 	echo jsonMessage("dataUpdated");
	// } else {
	// 	echo jsonMessage("Error updating data: " . $conn->error);
	// }
}

$conn->close();
?>