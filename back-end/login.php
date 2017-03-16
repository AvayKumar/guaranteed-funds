<?php
	
	$response = array();

	$response['status'] = 'ok';
	$response['message'] = 'Username and password do not match';

	echo json_encode($response);