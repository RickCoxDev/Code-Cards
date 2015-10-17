<?php

	/*$host_name  = "db588974136.db.1and1.com";
    $database   = "db588974136";
    $user_name  = "dbo588974136";
    $password   = "iamMyself5126!";*/

    $host_name  = "localhost";
    $database   = "codecards";
    $user_name  = "root";
    $password   = "";

    // Sets up connection with server
    $conn = mysqli_connect($host_name, $user_name, $password, $database);

    /*if (mysqli_connect_errno){
        echo "Could not connect to the database:" . $conn->error();
        exit();
    }*/

    // Recieves input from app.js
	$data = file_get_contents("php://input");
	$objData = json_decode($data);

?>
