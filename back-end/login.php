<?php

 $response = array();
 $response['message'] = '';
 
 $servername = "localhost";
 $username = "root";
 $password = "Cs0129";
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
 	 	
 	 	//$response['message'] = isset($_SESSION['u_id']);

 	} else {
 		$response['message'] = 'username and email does not match'; 
 		$response['status'] = 'error';
 		}
 	
 	 echo json_encode($response);



 }


?>