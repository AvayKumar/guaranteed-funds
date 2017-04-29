<?php
	
	$target_dir = 'uploads/';
	$file_name = time() . '_' .basename($_FILES['fileToUpload']['name']);
	$target_file = $target_dir . $file_name;
	$file_size = $_FILES['fileToUpload']['size'];
	$file_tmp = $_FILES['fileToUpload']['tmp_name'];

	session_start();

	if( isset($_SESSION['u_id']) ) {
		// Check if image file is a actual image or fake image
		if( $file_size <= 524288 ) {
		    $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
		    if($check !== false) {
	        	move_uploaded_file($file_tmp, $target_file);
	        	require './require/connection.inc.php';
	        	if($connection){
	        		$time_stamp = date('Y-m-d H:i:s');
	        		
	        		$sql_fileUpdate = "UPDATE `transaction_details` SET `file_name` = '{$file_name}',`upload_time`='{$time_stamp}' WHERE `user_id_donor` = '{$_SESSION['u_id']}' AND `amount` = '{$_POST['package']}' AND `have_paid` ='0'";
	        		$result_fileUpdate = mysqli_query($connection, $sql_fileUpdate);

	        	}
	        	
	        	header('Location: http://'. $_SERVER['SERVER_NAME'] .'/guaranteed-funds/#dashboard');
		    }
		}		
	}
