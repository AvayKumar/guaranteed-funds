<?php

	session_start();	

	$REFERRAL_WEIGHT = 1000;

 	$response = array();
	$response['pay_made'] = '0';
	$response['amount_recv'] = '0';
	$response['bonus'] = '0';
	$response['pay_received'] = '0';

	if(!isset($_SESSION['u_id'])) {
		$response['auth'] = false;
		die(json_encode($response));
	}

	$response['auth'] = true;
	//$response['id'] = $_SESSION['u_id'];

	require './require/connection.inc.php';
	
	/**
	Check if user has opted for donation
	*/
	$sql_donor = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}'";
	$result_donor = mysqli_query($connection,$sql_donor);

	 if(mysqli_num_rows($result_donor) == 0)
	 	$response['route_to_package'] = true;
	 else {

		$response['route_to_package'] = false;
		
		/**
		 * Count of payment made
		 */
		$sql_paid = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND user_id_receiver IS NOT NULL AND have_paid = '1'";

		$result_paid = mysqli_query($connection,$sql_paid);
		$payment_made_num = mysqli_num_rows($result_paid);
		$response['pay_made'] = $payment_made_num;

		/**
		 * Count of payment received 
		 */
		$sql_receiver = "SELECT * FROM transaction_details WHERE user_id_receiver = '{$_SESSION['u_id']}' AND have_paid = '1'";
		$result_receiver = mysqli_query($connection,$sql_receiver);
		$payment_received_num = mysqli_num_rows($result_receiver);

		$response['pay_received']  = $payment_received_num;

		$amount_received = 0;

		while($row_received = mysqli_fetch_assoc($result_receiver)) {
			$amount_received += $row_received['amount']; 	
		}

		$response['amount_recv'] = $amount_received;

		$sql_referral = "SELECT referral FROM user WHERE user_id = '{$_SESSION['u_id']}'";
		$result_referral = mysqli_query($connection, $sql_referral);

		$row_referral = mysqli_fetch_assoc($result_referral);

		$response['bonus'] = ($REFERRAL_WEIGHT)*($row_referral['referral']);

		/**
		 * Geat time left to pay amount, and user details of receiver
		 */

		$sql_timer = "SELECT a.time_stamp, a.amount, u.user_name, u.user_email, u.user_phone FROM `transaction_details` a JOIN `user` u ON a.user_id_receiver = u.user_id WHERE a.user_id_donor = '{$_SESSION['u_id']}' AND a.have_paid = '0' AND a.user_id_receiver IS NOT NULL";
		// {$_SESSION['u_id']}

		$date = date_create();

		$response['don'] = array();
		$result_time = mysqli_query($connection, $sql_timer);
		$i = 0;
		while($row = mysqli_fetch_assoc($result_time)) {
			$date_diff = date_diff(date_create($row['time_stamp']), $date); 
			$date_to = date_add($date, $date_diff);

			$response['don'][$i]['amount'] = $row['amount'];
			$response['don'][$i]['time_left'] = $date_to->format('m/d/Y h:i:s');
			$response['don'][$i]['name'] = $row['user_name'];
			$response['don'][$i]['email'] = $row['user_email'];
			$response['don'][$i++]['phone'] = $row['user_phone'];
		}


		/**
		 * Get details of all the matched user for current user
		 */
		$sql_receiver = "SELECT `amount`, `user_name`, `user_email`, `user_phone`, `file_name`, `transaction_id` FROM `user` u JOIN `transaction_details`a ON a.user_id_donor = u.user_id WHERE a.have_paid = '0' AND `user_id_receiver` = '{$_SESSION['u_id']}'";

		
		$response['rec'] = array();
		$result_receiver = mysqli_query($connection, $sql_receiver);
		$i = 0;
		while($row = mysqli_fetch_assoc($result_receiver)) {
			$response['rec'][$i]['amount'] = $row['amount'];
			$response['rec'][$i]['name'] = $row['user_name'];
			$response['rec'][$i]['email'] = $row['user_email'];
			$response['rec'][$i]['phone'] = $row['user_phone'];
			$response['rec'][$i]['tid'] = $row['transaction_id'];
			$response['rec'][$i++]['fileName'] = $row['file_name'] ? true: false;
		}

		/**
		 * Get number of waiting to be mergerd packages
		 */

		$sql_waiting = "SELECT `amount` FROM `transaction_details` WHERE `user_id_donor` = '{$_SESSION['u_id']}' AND `have_paid` = '0' AND `user_id_receiver` IS NULL";

		$response['wait'] = array();
		$result_waiting = mysqli_query($connection, $sql_waiting);

		$i = 0;
		while($row = mysqli_fetch_assoc($result_waiting)) {
			$response['wait'][$i++]['amount'] = $row['amount'];
		}

	}

	header('Content-Type: application/json');
	echo json_encode($response);