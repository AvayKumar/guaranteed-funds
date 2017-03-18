<?php
	
 //include('parse_string.php'); 
 //echo json_encode($_POST[amount]);
 
 $servername = "localhost";
 $username = "phpmyadmin";
 $password = "123";
 $database = "guaranteed_funds";
 
 $connection = new mysqli($servername, $username, $password, $database);
 
 if(mysqli_connect_error())
 	die(json_encode('connection_error'));
 
 else
 {
 	$sql_check_user = "SELECT * FROM `user`WHERE user_email = '{$_POST['email']}'";
	$result_check_user = mysqli_query($connection,$sql_check_user);
	if(mysqli_num_rows($result_check_user))	
		die(json_encode('error_email_exists'));
	
	$pass_hash = password_hash(trim($_POST['pwd']), PASSWORD_DEFAULT);

	$sql = "INSERT INTO  `user`(`user_name`, `user_email`, `user_refemail`, `user_password`, `user_phone`) VALUES('{$_POST['name']}','{$_POST['email']}','{$_POST['remail']}','{$pass_hash}','{$_POST['telephone']}')";
	$result_user = mysqli_query($connection,$sql);
	
	$u_id = "SELECT user_id FROM `user` WHERE user_email = '{$_POST['email']}'";
	$result_uid = mysqli_query($connection,$u_id);
	$row = mysqli_fetch_assoc($result_uid);
	
	$sql2 = "INSERT INTO `bank_details`(`user_id`, `bank_detail_name`, `bank_detail_accnt_name`, `bank_detail_accnt_number`, 				`bank_detail_amount`) VALUES ('{$row['user_id']}','{$_POST['bank_name']}','{$_POST['accnt_name']}','{$_POST['accnt_number']}','{$_POST['amount']}')";		
	$result_bank = mysqli_query($connection,$sql2);	  
 	
 	if($result_user && $result_bank)
	 	echo json_encode('created');
	else 
		echo json_encode('error_insertion'); 
 } 
 ?>