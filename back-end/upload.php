<?php
	
	$target_dir = 'uploads/';
	$target_file = $target_dir . time() . '_' .basename($_FILES['fileToUpload']['name']);
	$file_size = $_FILES['fileToUpload']['size'];
	$file_tmp = $_FILES['fileToUpload']['tmp_name'];

	session_start();

	if( isset($_SESSION['u_id']) ) {
		// Check if image file is a actual image or fake image
		if( $file_size <= 524288 ) {
		    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
		    if($check !== false) {
	        	move_uploaded_file($file_tmp, $target_file);
	        	header('Location: http://'. $_SERVER['SERVER_NAME'] .'/guaranteed-funds/#dashboard');
		    }
		}		
	}
