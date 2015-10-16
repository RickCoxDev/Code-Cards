<?php

	require_once "../includes/constants.php";

	// Fetches all unique deck names in user table
	$query = "SELECT DISTINCT deck FROM " . $objData->user;
	$results = mysqli_query($conn, $query);

	$output = [];
	
	// For each deck name it gets pushed into output array	
	if ($results !== NULL) {
		while ($row = mysqli_fetch_row($results)) {
			array_push($output, $row[0]);
		}
		echo json_encode($output);
	}
	else {
		echo False;
	}
?>