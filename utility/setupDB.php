<?php
    function setupDB($conn){
        $sql = "CREATE DATABASE IF NOT EXISTS login";

        if($conn->query($sql) === TRUE){
            echo "Database has been created\n";

            $conn->query("USE login");
        } else {
            die("Error creating database: " . $conn->error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS userdata(
            id INT(6) UNSIGNED AUTO_INCREMENT KEY,
            userid VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(30) NOT NULL,
            name VARCHAR(30) NULL,
            dob DATE,
            country VARCHAR(30) NULL,
            favcolor VARCHAR(30) NULL,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if($conn->query($sql) === TRUE){
            echo "Table has been created\n";
        } else {
            die("Error creating table: " . $conn->error);
        }

        $sql = "CREATE TABLE IF NOT EXISTS usertoken(
            id INT(6) UNSIGNED AUTO_INCREMENT KEY,
            userid VARCHAR(30) NOT NULL,
            token VARCHAR(200) NOT NULL UNIQUE,
            last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        if($conn->query($sql) === TRUE){
            echo "Table has been created\n";
        } else {
            die("Error creating table: " . $conn->error);
        }
    }
?>