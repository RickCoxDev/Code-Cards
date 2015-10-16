<?php

	require_once "../includes/constants.php";

	$output = ["output" => "", "error" => FALSE];

	// Searches for user based on email or their username
	$query = 'SELECT username FROM users WHERE (email = "' . $objData->user . '" OR username = "' . strtolower($objData->user) . '") AND password = "' . md5($objData->password) . '"';

	$results = mysqli_query($conn, $query);

	// If no results are returned send error
	if ($results->num_rows == 0){
		$output["error"] = true;
	}
	else {
		$results = $results->fetch_row();
		$output["output"] = $results[0];
	}

	echo json_encode($output);
?>