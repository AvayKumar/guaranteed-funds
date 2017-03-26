<?php

	require './require/connection.inc.php';

 
 	$sql_check_user = "SELECT * FROM `user`WHERE user_email = '{$_POST['email']}'";
	$result_check_user = mysqli_query($connection,$sql_check_user);
	
	if(mysqli_num_rows($result_check_user))	
		die(json_encode('error_email_exists'));
	
	$row_result_check_user = mysqli_fetch_assoc($result_check_user);
	
	$pass_hash = password_hash(trim($_POST['pwd']), PASSWORD_DEFAULT);

	$sql_insert = "INSERT INTO  `user`(`user_name`, `user_email`, `user_refemail`, `user_password`, `user_phone`) VALUES('{$_POST['name']}','{$_POST['email']}','{$_POST['remail']}','{$pass_hash}','{$_POST['telephone']}')";

	$result_insert = mysqli_query($connection,$sql_insert);
	

	$u_id = "SELECT `user_id`, `user_name` FROM `user` WHERE user_email = '{$_POST['email']}'";	
	$result_uid = mysqli_query($connection,$u_id);
	
	$row = mysqli_fetch_assoc($result_uid);
	
	
	$sql_bank = "INSERT INTO `bank_details`(`user_id`, `bank_detail_name`, `bank_detail_accnt_name`, `bank_detail_accnt_number`) VALUES ('{$row['user_id']}','{$_POST['bank_name']}','{$_POST['accnt_name']}','{$_POST['accnt_number']}')";		
	
	
	$result_bank = mysqli_query($connection,$sql_bank);	  
 	
 	if($result_insert && $result_bank){
	 	$response['state'] = 'true';
		session_start();
		$_SESSION['u_id'] = $row['user_id'];
		$_SESSION['u_name'] = $row['user_name'];
		$response['u_name'] = $_SESSION['u_name']; 
	}	
		
	echo json_encode($response); 
  
 ?>