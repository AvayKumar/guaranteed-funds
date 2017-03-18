<?php
	
	$response = array();
	
	$response['status'] = 'ok';
	$response['authenticated'] = true;

	echo json_encode($response);