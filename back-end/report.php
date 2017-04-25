<?php

	$_POST['name']		= trim( strtolower($_POST['name']) );
	$_POST['email']		= trim( strtolower($_POST['email']) );
	$_POST['email'] 	= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	$_POST['subject']	= trim( strtolower($_POST['subject']) );
	$_POST['message']	= trim( strtolower($_POST['message']) );


	$to = 'guaranteedfundsorg@gmail.com';
	$subject = 'Report User';
	$message = $_POST['message'];
	$headers = 'From: '.$_POST['email']."\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	mail($to, $subject, $message, $headers);

	$response['status'] = true;
	echo json_encode($response);