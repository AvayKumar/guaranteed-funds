<?php

 $response = array();
 $response['message'] = '';
 $response['loop'] = '';

 $servername = "localhost";
 $username = "phpmyadmin";
 $password = "123";
 $database = "guaranteed_funds";
 
 $connection = new mysqli($servername, $username, $password, $database);
 
 if(mysqli_connect_error())
 	die(json_encode('connection_error'));
 else {
 	$sql = "SELECT * FROM user WHERE user_email = '{$_POST['email']}'";
 	$result_email = mysqli_query($connection, $sql);
 	$row = mysqli_fetch_assoc($result_email);
 	if(mysqli_num_rows($result_email) == 0)
 		{
 			 $response['message'] = 'invalid_email'; 
	 		 $response['status'] = 'error';//echo (json_encode($response));
 			die(json_encode($response));
 		}

 	if(password_verify(trim($_POST['pwd']), $row['user_password']) ) {
 	 	$response['message'] = 'logging in';
 	 	$response['status'] = 'ok';
 	 	session_start();
 	 	$_SESSION['u_id'] = $row['user_id'];
 	 	
 	 	
 	 	$sql_plan_check = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND received_count < '2'";
 	 	$response['message'] = $sql_plan_check;
 	 	$result_plan_check = mysqli_query($connection,$sql_plan_check);
 	 	if(mysqli_num_rows($result_plan_check))
 	 		$response['loop'] = 'exists';
 	 	else
 	 		$response ['loop'] = 'not_exists'; 	 
		


 	} else {
 		$response['message'] = 'username and email does not match'; 
 		$response['status'] = 'error';
 		}
 	
 	 echo json_encode($response);



 }


?>