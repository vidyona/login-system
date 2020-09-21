<?php

function db_setup($conn){
  $sql_db_login = "CREATE DATABASE IF NOT EXISTS login;";
  
  if ($conn->query($sql_db_login) === FALSE) {
    echo message("Error creating database - " . $conn->error);
  }

  mysqli_select_db($conn, "login");

  $sql_t_userdata = "CREATE TABLE IF NOT EXISTS userdata (
    userid VARCHAR(20) NOT NULL PRIMARY KEY,
    password varchar(50) NOT NULL,
    name varchar(50) NOT NULL,
    dob date  NOT NULL,
    country varchar(50) NOT NULL,
    favcolor varchar(50) NOT NULL
  );";

if ($conn->query($sql_t_userdata) === FALSE) {
  echo message("Error creating Table - " . $conn->error);
}

  $sql_t_usertoken = "CREATE TABLE IF NOT EXISTS usertoken (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid varchar(20) NOT NULL,
    token varchar(255) NOT NULL
  );";
  
  if ($conn->query($sql_t_usertoken) === FALSE) {
    echo message("Error creating Table - " . $conn->error);
  }

}
?>