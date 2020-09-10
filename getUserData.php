<?php
function getuserdata($conn, $s_userid){
	$query = "SELECT name, dob, country, favcolor
			FROM userdata WHERE userid LIKE '$s_userid'";

	$userdataQ = mysqli_query($conn, $query);
		
	if($row = mysqli_fetch_array($userdataQ)){
		$message = "logged in";
		$name = $row["name"];
		$dob = $row["dob"];
		$country = $row["country"];
		$favcolor = $row["favcolor"];

		$userData = new UserData();

		$userData->message = $message;
		$userData->name = $name;
		$userData->dob = $dob;
		$userData->country = $country;
		$userData->favcolor = $favcolor;

		return $userData;
	} else {
		return $row;
	}
}
?>