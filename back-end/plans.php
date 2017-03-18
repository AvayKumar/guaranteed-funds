<?php
	
	$response = array();

	if( isset($_POST['package'])) {
		$response['packageSelected'] = true;
		$response['package'] = $_POST['package'];		
	} else {
		$response['packageSelected'] = false;
	}

	echo json_encode($response);