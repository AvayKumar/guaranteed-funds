<?php

	$servername = "localhost";
	$username = "phpmyadmin";
	$password = "123";
	$database = "guaranteed_funds";
	
	$connection = new mysqli($servername, $username, $password, $database);
	if(mysqli_connect_error()) {
		$response['message'] = 'connection error';	
		die(json_encode($response));
	}
