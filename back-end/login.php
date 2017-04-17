<?php

	require './require/connection.inc.php';

	$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$_POST['email'] = trim( strtolower($_POST['email']) );
	$_POST['pwd']  	= filter_var($_POST['pwd']);

	$sql = "SELECT `user_password`, `user_id`, `user_name`, `user_blocked` FROM user WHERE user_email = '{$_POST['email']}'";
	$result_email = mysqli_query($connection, $sql);

	$row = mysqli_fetch_assoc($result_email);

	if(mysqli_num_rows($result_email) == 0) {
		 $response['user_verify'] = 'Invalid email'; 
		 $response['status'] = false;
		die(json_encode($response));
	}

	if( password_verify(trim($_POST['pwd']), $row['user_password']) ) {
	 	
	 	if( !$row['user_blocked'] ) {
	 		$response['status'] = true;
	 		session_start();
		 	$_SESSION['u_id'] = $row['user_id'];
		 	$_SESSION['u_name'] = $row['user_name'];
	 		$response['u_name'] = $_SESSION['u_name'];
	 	} else {
	 		$response['blocked'] = true;
	 		die(json_encode($response));
	 	}

	 	$sql_plan_check = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND received_count < '2'";
	 	$result_plan_check = mysqli_query($connection, $sql_plan_check);
	 	
	 	if(mysqli_num_rows($result_plan_check))
	 		$response['loop_exist'] = true;
	 	else
	 		$response['loop_exist'] = false; 	  	

	} else {
		$response['user_verify'] = 'Username and password do not match'; 
		$response['status'] = false;
	}

echo json_encode($response);

?>