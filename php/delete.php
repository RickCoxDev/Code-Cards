<?php
	require_once "../includes/constants.php";

	// Deletes each card from selected deck
	$query = 'DELETE FROM ' . $objData->user . ' WHERE deck = "' . $objData->deckName . '"';
	$conn->query($query);

	// Refetches all unique deck names from user table
	$query = "SELECT DISTINCT deck FROM " . $objData->user;
	$conn->query($query);

	$output = [];
	while ($row = $results->fetch_row) {
		array_push($output, $row[0]);
	}

	echo json_encode($output);
?>
