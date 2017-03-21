<?php
 session_start();	
 
 $weight_referral = 1000;

 // $response = array();
 // $response['status'] = '';
 // $response['message'] = '';
 // $response['route_to_package'] = '';
 // $response['pay_received'] = '0';
 
 $response['pay_made'] = '0';
 $response['amount_recv'] = '0';
 $response['bonus'] = '0';
 $response['pay_received'] = '0';

 if(!isset($_SESSION['u_id']))
	{
		$response['status'] = 'false';
		$response['session'] = 'session_not_set';
		die(json_encode($response));
	}

$response['status'] = 'true';
$response['session'] = 'session_set';	
//$response['u_name'] = $_SESSION['u_name'];
 //$response['id'] = $_SESSION['u_id'];
require './require/connection.inc.php';
	

 $sql_donor = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}'";
 $result_donor = mysqli_query($connection,$sql_donor);

 if(mysqli_num_rows($result_donor) == 0)
 	$response['route_to_package'] = 'true';
 
 else 
 {
	 $response['route_to_package'] = 'false';
	 
	 $sql_paid = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND user_id_receiver IS NOT NULL AND have_paid = '1' ";
	 $result_paid = mysqli_query($connection,$sql_paid);

	 $payment_made_num = mysqli_num_rows($result_paid);
	 
	 $response['pay_made'] = $payment_made_num;

	 $sql_receiver = "SELECT * FROM transaction_details WHERE user_id_receiver = '{$_SESSION['u_id']}' AND have_paid = '1' ";
	 $result_receiver = mysqli_query($connection,$sql_receiver);

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
	 
	 $response['bonus'] = ($weight_referral)*($row_referral['referral']);	

 }
 echo json_encode($response);


?>
