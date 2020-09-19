<?php

function db_setup($conn){
  $sql_db = "CREATE DATABASE IF NOT EXISTS login;";
  
  if ($conn->query($sql_db) === FALSE) {
    message("Error creating database - " . $conn->error);
  }

  mysqli_select_db($conn, "login");

  $sql_db = "CREATE TABLE IF NOT EXISTS userdata (
    userid VARCHAR(20) NOT NULL PRIMARY KEY,
    password varchar(50) NOT NULL,
    name varchar(50) NOT NULL,
    dob date  NOT NULL,
    country varchar(50) NOT NULL,
    favcolor varchar(50) NOT NULL
  );";

if ($conn->query($sql_db) === FALSE) {
  message("Error creating Table - " . $conn->error);
}

  $sql_db = "CREATE TABLE IF NOT EXISTS usertoken (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid varchar(20) NOT NULL,
    token varchar(255) NOT NULL
  );";
  
  if ($conn->query($sql_db) === FALSE) {
    message("Error creating Table - " . $conn->error);
  }

}
?>