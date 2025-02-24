<?php
    ob_start(); //turns on output buffering
    session_start();
    date_default_timezone_set("Asia/Manila");

    // connect the database
    try {
        // connect the database
        $con = new PDO("mysql:dbname=reeceflix;host=localhost", "root", "");
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    catch (PDOException $e) {
        // stop running php and display error message
        exit("Connection failed: " . $e->getMessage());
    }
?>