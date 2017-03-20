<?php
	

	function authStatus() {
		require 'authenticate.inc.php';
		$response = array();
		$response['auth'] = isAuthenticated();
		$response['success'] = true;
		echo json_encode($response);
	}

	function signOut() {
		session_start();
		session_unset(); 
		session_destroy(); 
		$response = array();
		$response['success'] = true;
		echo json_encode($response);
	}

	if( isset($_GET['func_name']) ) {
		call_user_func($_GET['func_name']);	
	} else {
		$response = array();
		$response['success'] = false;
		echo json_encode($response);
	}