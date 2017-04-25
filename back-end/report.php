<?php

	require './require/connection.inc.php';
	
	session_start();
	
	if(!isset($_SESSION['u_id'])) {
		$response['session'] = 'session_not_set';
		die(json_encode($response));
	}

	$sql="SELECT `user_name`, `user_email`, `user_phone` FROM `user` WHERE `user_id`='{$_SESSION['u_id']}'";
	$res=mysqli_query($connection,$sql);

	if($res){

	$row=mysqli_fetch_assoc($res);	
		
	$_POST['name']		= trim( strtolower($_POST['name']) );
	$_POST['email']		= trim( strtolower($_POST['email']) );
	$_POST['email'] 	= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	// $_POST['subject']	= trim( strtolower($_POST['subject']) );
	$_POST['message']	= trim( strtolower($_POST['message']) );


	$to = 'guaranteedfundsorg@gmail.com';
	$subject = 'Report User';
	$message = 'Block the user with details as:'."\r\n". 
				'email:'.$_POST['email']."\r\n".
				'user name: '.$_POST['name']."\r\n".
				'phone number: '.$_POST['phone']."\r\n".
				$_POST['message']."\r\n".
				'From:'."\r\n".
				'name:'.$row['user_name']."\r\n".
				'email'.$row['user_email']."\r\n".
				'phone'.$row['user_phone']."\r\n";

	$headers = 'From: '.$row['user_email']."\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

	$response['status'] = true;
	echo json_encode($response);

	}