<?php
function message($message){
    $json_message = str_replace(";", "\;", $message);

    echo '{"message":"'. $json_message .'"}';
}
?>