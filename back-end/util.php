<?php
	

	function authStatus() {
		require 'authenticate.inc.php';
		$response = array();
		$response['success'] = false;
		$response['auth'] = isAuthenticated();
		$response['success'] = true;
		if(isset($_SESSION['u_id']))
			$response['user_name'] = $_SESSION['u_name'];
		// if($response['success']){
			
		// 	require './require/connection.inc.php';
		// 	if($connection){
		// 		$sql_user = "SELECT user_name FROM  user WHERE user_id = '{$_SESSION['u_id']}'";
		// 		$result_user = mysqli_query($connection,$sql_user);
		// 		$row = mysqli_fetch_assoc($result_user);
		// 		$_SESSION['user'] = $row['user_name'];
		// 		$response['user'] = $row['user_name'];
		// 	}


		// }
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

    function confirmPayment(){
    	session_start();
    	$response = array();
    	if(isset($_SESSION['u_id'])){
    		require './require/connection.inc.php';
    		$sql_confirmPay = "UPDATE `transaction_details` SET `have_paid` = '1' WHERE transaction_id = '{$_POST['tid']}'";
    		$result_confirmPay = mysqli_query($connection, $sql_confirmPay);
    		$response['success'] = true;
    	} 
    	else 
    		$response['error'] = 'Not authenticated';
    	echo json_encode($response);

    }

	if( isset($_GET['func_name']) ) {
		call_user_func($_GET['func_name']);	
	} else {
		$response = array();
		$response['success'] = false;
		echo json_encode($response);
	}

