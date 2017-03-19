<?php
 session_start();	
 
 $weight_referral = 1000;

 $response = array();
 $response['status'] = '';
 $response['message'] = '';
 $response['route_to_package'] = '';
 $response['pay_received'] = '0';
 $response['pay_made'] = '0';
 $response['amount_recv'] = '0';
 $response['bonus'] = '0';
 if(!isset($_SESSION['u_id']))
	{
		$response['status'] = 'false';
		$response['message'] = 'session_not_set';
		die(json_encode($response));
	}

$response['status'] = 'true';
$response['message'] = 'session_set';	
/*	
else{		
		$response['status'] = 'true';
		$response['message'] = 'session_set';
		echo json_encode($response);
	}
*/

 $servername = "localhost";
 $username = "root";
 $password = "Cs0129";
 $database = "guaranteed_funds";
 
 $connection = new mysqli($servername, $username, $password, $database);
 
 if(mysqli_connect_error())
 {
 	$response['message'] = 'connection error';	
 	die(json_encode($response));
 }
 	

 $sql_donor = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}'";
 $result_donor = mysqli_query($connection,$sql_donor);

 if(mysqli_num_rows($result_donor) == 0)
 	$response['route_to_package'] = 'true';
 
 else 
 {
	 $response['route_to_package'] = 'false';
	 
	 $sql_paid = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND user_id_receiver IS NOT NULL";
	 $result_paid = mysqli_query($connection,$sql_paid);

	 $payment_made_num = mysqli_num_rows($result_paid);
	 $response['pay_made'] = $payment_made_num;

	 $sql_receiver = "SELECT * FROM transaction_details WHERE user_id_receiver = '{$_SESSION['u_id']}'";
	 $result_receiver = mysqli_query($connection,$sql_receiver);

	 //$row_received = mysqli_fetch_assoc($result_receiver);
	 $payment_received_num = mysqli_num_rows($result_receiver);
	 $response['pay_received']  = $payment_received_num;

	 $amount_received = 0;
	 while($row_received = mysqli_fetch_assoc($result_receiver))
	 	{
			$amount_received += $row_received['amount']; 	
	 	}
	 $response['amount_recv'] = $amount_received;


	 $sql_referral = "SELECT referral FROM user WHERE user_id = '{$_SESSION['u_id']}'";
	 $result_referral = mysqli_query($connection, $sql_referral);
	 $row_referral = mysqli_fetch_assoc($result_referral);
	 $response['bonus'] = $weight_referral*$row_referral['referral'];	

 }
 echo json_encode($response);


?>
