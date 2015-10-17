<?php
 
require_once "dbhelper.php";

//create array to use as output
$output = ["data" => [], "error" => ["errorCode" => "", "errorMsg" => ""]];

// retrieve the request method and url
$method = $_SERVER["REQUEST_METHOD"];
$url = array_slice(explode("/", $_SERVER["REQUEST_URI"]), 5);

if ($method = "GET") {
    if ($url[0] == "decks") {
                
        if ($url[2] == "terms") {
            // Just the terms of the deck
            echo deckCards(1);
        }
    }
}
//echo json_encode($url);
     
/*switch ($method) {
    case 'GET':
    	if ($url[0] == "decks") {
    		
    		if ($url[2] == "terms") {
                // Just the terms of the deck
                echo deckCards(1);
    		}
    		elseif (is_null($url[2])) {
                // All of the deck's details
    		}
    		else {
    			//error
    		}
    	}
    	elseif ($url[0] == "users") {
    		
    		if ($url[2] == "decks") {
                // user created deck details
    		}
    		elseif (is_null($url[2])) {
    			// basic user info
    		}
    		else {
    			//error
    		}
    	}
    	else {
    		//error
    	}
        break;

    case 'POST':
        if ($url[0] == "decks") {
            // add a new deck
        }
        else {
        	//error
        }
        break;

    case 'PUT' :
    	if ($url[0] == "decks") {
            // edit existing deck
    	}
    	else {
    		//error
    	}
    	break;

   	case 'DELETE' :
   		if ($url[0] == "decks") {
            // deletes deck
   		}
   		else {
   			//error
   		}
   		break;
        
    default:
        # code...
        break;
}

array_push($output, $method);
array_push($output, $url);

echo json_encode($output);*/
?>