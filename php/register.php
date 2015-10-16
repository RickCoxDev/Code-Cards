<?php
	require_once "../includes/constants.php";

	$output = ["output" => "", "error" => FALSE];

	$query = 'SELECT * FROM users WHERE email = "' . $objData->email . '" LIMIT 1';
	$results = $conn->query($query);

	// If the email is not already
	// used by another user
	if ($results->num_rows() == 0){
		$query = 'SELECT * FROM users WHERE username = "' . $objData->username . '" LIMIT 1';
		$results = $conn->query($query);

		// If the username is not already
		// used by another user
		if ($results->num_rows() == 0){
			$query = 'INSERT INTO users (email, username, password) VALUES ("' . $objData->email . '", "' . strtolower($objData->username) . '",  "' . md5($objData->password) . '")';
			$conn->query($query);

			$query = 'CREATE TABLE ' . strtolower($objData->username) . ' ( id INT(100) NOT NULL AUTO_INCREMENT , term VARCHAR(15) NOT NULL , description VARCHAR(50) NOT NULL , deck VARCHAR(15) NOT NULL , PRIMARY KEY (id) )';
			$conn->query($query);

			$output["output"] = strtolower($objData->username);
		}
		else {
			$output["error"] = "username";
		}
	}
	else {
		$output["error"] = "email";
	}

	echo json_encode($output);
?>