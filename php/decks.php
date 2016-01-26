<?php

	require_once "../includes/constants.php";

	// Fetches all unique deck names in user table
	$query = "SELECT DISTINCT deck FROM " . $objData->user;
	$results = $conn->query($query);

	$output = [];
	
	// For each deck name it gets pushed into output array	
	if ($results !== NULL) {
		while ($row = $results->fetch_row()) {
			array_push($output, $row[0]);
		}
		echo json_encode($output);
	}
	else {
		echo False;
	}
?>