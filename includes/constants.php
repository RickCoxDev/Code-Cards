<?php

	/*$host_name  = "db588974136.db.1and1.com";
    $database   = "db588974136";
    $user_name  = "dbo588974136";
    $password   = "iamMyself5126!";*/

    $host_name  = "localhost";
    $database   = "codecards";
    $user_name  = "root";
    $password   = "123123";

    // Sets up connection with server
    $conn = new mysqli($host_name, $user_name, $password, $database);

    // Recieves input from app.js
	$data = file_get_contents("php://input");
	$objData = json_decode($data);

?>
