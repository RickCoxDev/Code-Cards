<?php

	require_once "../includes/constants.php";

	// If the deck name is empty create a new deck
	if ($objData->deckName != "") {

		$query = 'SELECT term, description, deck FROM ' . $objData->user . ' WHERE deck = "' . $objData->deckName . '"';

		if ($results = $conn->query($query)) {

			// Pushes each individual card into the array
			$output = [];
			while ($row = mysqli_fetch_assoc($results)) {
				array_push($output, $row);
			}

			echo json_encode($output);
		}

	}
	else {
		$output = [["term" => "", "description" => "", "deck" => ""]];
		echo json_encode($output);
	}
?>