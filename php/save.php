<?php

	require_once "../includes/constants.php";

	// Delete all cards from the deck off the database
	$query = 'DELETE FROM ' . $objData->user . ' WHERE deck = "' . $objData->deckName . '"';
	$conn->query($query);

	// Creates prepared statement
	$query = 'INSERT INTO ' . $objData->user . '(term, description, deck) VALUES (?, ?, ?)';

	// Inserts cards into database one at a time
	if ($stmt = $conn->prepare($query))
		foreach ($objData->cards as $card) {
			if ($card->term !== "" || $card->description !== "") {
				$conn->query($query . '("' . $card->term . '", "' . $card->description . '", "' . $objData->deckName . '")');
				$stmt->bind_param("sss", $card->term, $card->description, $objData->deck);
				$stmt->execute();
			}
		}
		$stmt->close();
	}
?>
