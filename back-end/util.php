<?php
	

	function authStatus() {
		require 'authenticate.inc.php';
		$response = array();
		$response['success'] = false;
		$response['auth'] = isAuthenticated();
		$response['success'] = true;
		if(isset($_SESSION['u_id']))
			$response['user_name'] = $_SESSION['u_name'];
		echo json_encode($response);
	}

	function authStatus2() {
		require 'authenticate.inc.php';
		$response = array();
		$response['success'] = false;
		$response['auth'] = isAuthenticated();
		$response['success'] = true;
		if(isset($_SESSION['u_id']))
			{
				$response['user_name'] = $_SESSION['u_name'];
				require 'require/connection.inc.php';
				
				$sql_Details = "SELECT `user_phone`, `bank_detail_accnt_name` AS account_name, `user_email`, `bank_detail_name` AS bank_name, `bank_detail_accnt_number` AS account_number FROM `user` u JOIN `bank_details` b ON u.user_id = b.user_id WHERE u.user_id = '{$_SESSION['u_id']}'";
				$result_Details = mysqli_query($connection, $sql_Details);
				if($result_Details)
					{
						$row = mysqli_fetch_assoc($result_Details);
						$response['phone'] = $row['user_phone']; 
						$response['account_name'] = $row['account_name'];
						$response['account_number'] = $row['account_number'];
						$response['bank_name'] = $row['bank_name'];
						$response['email'] = $row['user_email'];
					}
			}
		echo json_encode($response);
	}

	function signOut() {
		session_start();
		session_unset(); 
		session_destroy(); 
		$response = array();
		$response['success'] = true;
		echo json_encode($response);
	}

	function editProfile() {
		 session_start();
		 if(isset($_SESSION['u_id'])){
		 	require './require/connection.inc.php';
			
			$sqlMyemail = "SELECT `user_email` FROM `user` WHERE `user_id` = '{$_SESSION['u_id']}'";
			$resMyemail = mysqli_query($connection, $sqlMyemail);
			if($resMyemail)
				$rowMyemail = mysqli_fetch_assoc($resMyemail);

			$_POST['email']		= trim( strtolower($_POST['email']) );
			$_POST['email'] 	= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	
		 	$sqlCheck = "SELECT `user_email` FROM `user` WHERE `user_email` = '{$_POST['email']}'";
		 	$resCheck = mysqli_query($connection, $sqlCheck);
		 			 	
		 	if($resCheck)
		 		$rowCheck = mysqli_fetch_assoc($resCheck);

		 	if( $resCheck && (mysqli_num_rows($resCheck) == 0 || 
		 		(mysqli_num_rows($resCheck) == 1 && $rowCheck['user_email'] == $rowMyemail['user_email']) ) 
		 	   ){
				 	$sqlEdit = "UPDATE `user` SET `user_name` = '{$_POST['name']}', `user_email` = '{$_POST['email']}', `user_phone` = '{$_POST['contact']}' WHERE user_id = '{$_SESSION['u_id']}' ";
				 	$resultEdit = mysqli_query($connection, $sqlEdit);
				 	
				 	$sqlEdit2 = "UPDATE `bank_details` SET `bank_detail_name` = '{$_POST['bank_name']}', bank_detail_accnt_name = '{$_POST['accnt_name']}', `bank_detail_accnt_number` = '{$_POST['accnt_number']}' WHERE user_id = '{$_SESSION['u_id']}' ";

				 	$resultEdit2 = mysqli_query($connection, $sqlEdit2);

				 	if($resultEdit && $resultEdit2){
				 		$response['log'] = 'Changed Succesfully';
				 		$response['state'] = true;
				 	}
				 	else{
				 		$response['log'] = 'Error in bank details or user details';
				 		$response['state'] = false;
				 	}	
		 	 	}
		 	else {
		 	 	$response['state'] = false;
		 	 	$response['log'] = 'Choose another email';
		 	 }
		 	 echo json_encode($response);
		 }
		
	}

	function sendEmail(){

		require 'require/connection.inc.php';

		$sqlEmail="SELECT `user_email`,`user_id` FROM `user` WHERE `user_email` = '{$_POST['email']}'";
		$resEmail=mysqli_query($connection,$sqlEmail);

		$response['state']=true;
		
		if($resEmail && mysqli_num_rows($resEmail)==0)
			{ 
				$response['user_verify']='Invalid Email';
				$response['state']=false;
			}
		else{	
				$time_stamp = date('Y-m-d H:i:s');
				$token = password_hash(($time_stamp), PASSWORD_DEFAULT);
				
				$row=mysqli_fetch_assoc($resEmail);

				$sql_token="UPDATE `user` SET `token`='{$token}' WHERE `user_email`='{$row['user_email']}'";
				$res_token=mysqli_query($connection,$sql_token);

				$response['user_verify']='Mail Sent Succesfully';
			
				$to      = $row['user_email'];
				$subject = 'Password reset';
				$message = 'To change your password use the token below.'."\r\n".
						    'at the url:http://guaranteedfunds.org/#recover?t='.$token."\r\n"."\r\n".'&u='.$row['user_id']."\r\n".
						    // 'at the url:http://guaranteedfunds.org/#recover'."\r\n"."\r\n".
							'Token:'."\r\n"."\r\n".
							$token;
				$headers = 'From: support@guaranteedfunds.org' . "\r\n" .
				    'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);
				// echo $x;
			}

		echo json_encode($response);
	}

	function changePassword(){
	
		require 'require/connection.inc.php';
		
		// $_POST['email']	= trim( strtolower($_POST['email']) );
		// $_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	
		$sql="SELECT `token` FROM `user` WHERE `user_id`='{$_POST['user']}'";
		$res=mysqli_query($connection,$sql);

		$response['state']=false;

		if($res){
		
		$row=mysqli_fetch_assoc($res);
		$_POST['token']= filter_var($_POST['token']);
		
		if(mysqli_num_rows($res)==0)
		{
			$response['log']='Invalid Request';
			die(json_encode($response));
		}

		if( (trim($_POST['token'])== $row['token']) ) {		
			
			$pass = password_hash(($_POST['pwd']), PASSWORD_DEFAULT);
			$sql_pwd="UPDATE `user` SET `user_password`= '{$pass}' WHERE `user_id`='{$_POST['user']}'";
			$res_pwd=mysqli_query($connection,$sql_pwd);

			if($res_pwd){
				$response['log']='Password Changed';
				$response['state']=true;
			}
			else
				$response['log']='Unexpected error';
		}
		else{
			$response['log']='Invalid Request';
		}	

		}

		echo json_encode($response);	
	}


    function confirmPayment(){
    	session_start();
    	$response = array();
    	if(isset($_SESSION['u_id'])){
    		require './require/connection.inc.php';
    		$sql_confirmPay = "UPDATE `transaction_details` SET `have_paid` = '1' WHERE transaction_id = '{$_POST['tid']}'";
    		$result_confirmPay = mysqli_query($connection, $sql_confirmPay);
    		
    		$sql_updateReceive = "UPDATE `transaction_details` SET `received_count` = `received_count` + 1 WHERE amount = '{$_POST['amount']}' AND user_id_donor = '{$_SESSION['u_id']}' AND have_paid < 2";
    		$result_updateReceive = mysqli_query($connection, $sql_updateReceive);
    		
    		$response['success'] = true;
    	} 
    	else 
    		$response['error'] = 'Not authenticated';
    	echo json_encode($response);

    }


	if( isset($_GET['func_name']) ) {
		call_user_func($_GET['func_name']);	
	} else {
		$response = array();
		$response['success'] = false;
		echo json_encode($response);
	}

