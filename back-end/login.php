<?php

 $response = array();
 $response['message'] = 'Invalid';
 
 $servername = "localhost";
 $username = "phpmyadmin";
 $password = "123";
 $database = "guaranteed_funds";
 
 $connection = new mysqli($servername, $username, $password, $database);
 
 if(mysqli_connect_error())
 	die(json_encode('connection_error'));
 else  {
 	$sql = "SELECT * FROM user WHERE user_email = '{$_POST['email']}'";
 	$result_email = mysqli_query($connection, $sql);
 	$row = mysqli_fetch_assoc($result_email);
 	if(mysqli_num_rows($result_email) == 0)
 		die(json_encode('invalid_email'));
 	

 	if(password_verify(trim($_POST['pwd']), $row['user_password']) ) {
 	 	$response['message'] = 'logging in';
 	 	 $response['status'] = 'ok';
 	} else {
 		$response['message'] = 'useranme and email does not match'; 
 		 $response['status'] = 'error';
 	}
 	 echo json_encode($response);



 }


?>