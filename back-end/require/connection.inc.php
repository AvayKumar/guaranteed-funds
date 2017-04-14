<?php

	$servername = "localhost";
	$username = "root";
	$password = "Cs0129";
	$database = "guaranteed_funds";
	
	$connection = new mysqli($servername, $username, $password, $database);
	if(mysqli_connect_error()) {
		$response['message'] = 'connection error';	
		die(json_encode($response));
	}
