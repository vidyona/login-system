<?php
require_once "utility.php";

if(isset($_POST["name"])
&& isset($_POST["dob"])
&& isset($_POST["country"])
&& isset($_POST["favcolor"])){
	$name = $_POST["name"];
	$dob = $_POST["dob"];
	$country = $_POST["country"];
	$favcolor = $_POST["favcolor"];
}else{
	echo '{"loginStatus": "variables not set"}';
}

if(isset($_COOKIE["token"])){
	$clientToken = $_COOKIE["token"];
} else {
	die('{"loginStatus": "not logged in"}');
}

$conn = openConnection();

$conn->query("USE login");
	
$userId = getTokenUser($conn, $clientToken);

$sql = "UPDATE userdata SET name = '$name', country = '$country', favcolor = '$favcolor' WHERE userid LIKE '$userId'";

if($conn->query($sql) === TRUE){
	echo '{"loginStatus": "dataUpdated"}';
} else {
	echo "Error updating data: " . $conn->error;
}

if($dob == ""){
	if($conn->query("UPDATE userdata SET dob = NULL WHERE userid LIKE '$userId'") !== TRUE){
		echo $conn->error;
	}
} else {
	if($conn->query("UPDATE userdata SET dob = '$dob' WHERE userid LIKE '$userId'") !== TRUE){
		echo $conn->error;
	}
}

$conn->close();
?>