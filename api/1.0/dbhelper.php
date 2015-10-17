<?php

function deckCards($deckId) {

	require_once "/config.php";

	$output = [];

	$query = 'SELECT deck_name FROM decks WHERE id = ' . $deckId;
	$results = mysqli_query($conn, $query);

	if ($results->num_rows) {
		$deckName = $results->fetch_row();
		
		$query = 'SELECT id, term, definition FROM cards WHERE deck_id = ' . $deckId;
		$results = mysqli_query($conn, $query);

		if ($results->num_rows) {
			// Pushes each individual card into the array
			$cards = [];
			while ($row = mysqli_fetch_assoc($results)) {
				array_push($cards, $row);
			}

			// cards are successfully retrieved
			$status = ["code" => "200", "statusMsg" => "OK", "clientMsg" => "Everything's Okey Dokey!"];
		}
		else {
			// empty card is created if the deck has no cards
			$cards = [["id" => 0, "term" => "", "definition" => ""]];
			$status = ["code" => "200", "statusMsg" => "OK", "clientMsg" => "Everything's Okey Dokey!"];
		}

		// cards are added to the deck array
		$decks = ["deckName" => $deckName[0], "cards" => $cards];
		$output = ["status" => $status, "payload" => $deck];
	}
	else {
		// the deck was not found
		$status = ["code" => "404", "statusMsg" => "Resource Not Found", "clientMsg" => ""];
		array_push($output, $status);
	}

	return $output;
}

function userDecks($username) {
	// Fetches all unique deck names in user table
	$query = 'SELECT DISTINCT deck FROM decks WHERE createdBy = ' . $username;
	$results = mysqli_query($conn, $query);
	
	$decks = [];
	// For each deck name it gets pushed into output array	
	if ($results->num_rows) {
		while ($row = mysqli_fetch_row($results)) {
			array_push($decks, $row[0]);
		}
		$status = ["code" => "200", "statusMsg" => "OK", "clientMsg" => "Everything's Okey Dokey!"];
	}
	else {
		$status = ["code" => "404", "statusMsg" => "Resource not found", "clientMsg" => "An error occured or this user has not decks."];
	}

	$output = ["status" => $status, "payload" => $decks];
	return $output;
}

function userInfo($username) {
	// Retrieves users basic info
	$query = "SELECT * FROM users WHERE username = '" . $username . "'";
	$results = mysqli_query($conn, $query);
	$user = [];

	if ($results->num_rows) {
		$user = ["id" => $results[0], "username" => $results[1], "email" => $results[2]];
		$status = ["code" => "200", "statusMsg" => "OK", "clientMsg" => "Everything's Okey Dokey!"];
	}
	else {
		$status = ["code" => "404", "statusMsg" => "Resource not found", "clientMsg" => "An error occured or this user has not decks."];		
	}

	$output = ["status" => $status, "payload" => $user];
	return $output;
}

function newDeck($cardss) {
	foreach ($variable as ) {
		# code...
	}
}

function deleteDeck($deckId) {
	$query = 'DELETE FROM ' . $objData->user . ' WHERE deck = "' . $objData->deckName . '"';
	mysqli_query($conn, $query);

	// Refetches all unique deck names from user table
	$query = "SELECT DISTINCT deck FROM " . $objData->user;
	mysqli_query($conn, $query);

	$output = [];
	while ($row = $results->fetch_row()) {
		array_push($output, $row[0]);
	}

	echo json_encode($output);
}


?>