<?php
function dateTime(){
    $getdate = getdate();
	$date = $getdate['mday'].'th '.$getdate['month'].', '.$getdate['year'];
	$time = $getdate['hours'].':'.$getdate['minutes'].':'.$getdate['seconds'];
	return '{"message":"data updated", "date":"'.$date.'", "time":"'.$time.'"}';
}
?>