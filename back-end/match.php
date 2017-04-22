<?php

	require './require/connection.inc.php';

	session_start();

	$response['insert'] = 'check'; 
	$num_packages = 6;
	$package = array('10000','30000','50000','100000','200000','500000');
	$match = array();
	$j = 0;
	for($i = 0; $i < $num_packages ; $i++)
	{		
		// $query_donor = "SELECT `transaction_id`, `user_id_donor`, `user_id_receiver`, `amount`, `have_paid`, `received_count`,`time_stamp` FROM transaction_details WHERE `user_id_receiver` IS NULL AND `amount` = '{$package[$i]}' ORDER BY `time_stamp`";

		$query_donor="SELECT t.user_id_donor AS `user_id_donor`,t.transaction_id AS `transaction_id` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor=u.user_id WHERE t.user_id_receiver IS NULL AND t.amount='{$package[$i]}' AND u.user_blocked='0' ORDER BY t.time_stamp";
			   
		$result_donor = mysqli_query($connection, $query_donor);

		
		// $query_receiver = "SELECT `transaction_id`, `user_id_donor`, `user_id_receiver`, `amount` FROM `transaction_details` WHERE `amount`='{$package[$i]}' AND `have_paid`='1' AND `received_count`<'2' AND `user_id_donor` NOT IN ( SELECT `user_id_receiver` AS `user_id_donor` FROM `transaction_details`  WHERE `user_id_receiver`IS NOT NULL AND `amount`='{$package[$i]}' AND `have_paid`='0' GROUP BY `user_id_receiver` HAVING count(*) = '2' )"; 


		$query_receiver="SELECT t.user_id_donor AS `user_id_donor`,t.transaction_id AS `transaction_id` FROM `transaction_details` t INNER JOIN `user` u ON t.user_id_donor = u.user_id  WHERE  t.have_paid ='1' AND t.amount ='{$package[$i]}' AND t.received_count < '2' AND u.user_blocked='0' AND `user_id_donor` NOT IN ( SELECT `user_id_receiver` AS `user_id_donor` FROM `transaction_details`  WHERE `user_id_receiver`IS NOT NULL AND `amount`='{$package[$i]}' AND `have_paid`='0' GROUP BY `user_id_receiver` HAVING count(*) = '2' )";
	
		$result_receiver = mysqli_query($connection, $query_receiver);				   		
		
		
		
		if( $result_donor && $result_receiver ) {
			while( ($row1 = mysqli_fetch_assoc($result_donor)) && ($row2 = mysqli_fetch_assoc($result_receiver) )){
					$match[$j]['amount'] = $package[$i];
					$match[$j]['receiver_tid'] = $row2['transaction_id'];
					$match[$j]['donor_tid'] = $row1['transaction_id'];
					$match[$j]['D'] = $row1['user_id_donor'];
					$match[$j]['R'] = $row2['user_id_donor'];
					$j++;
					   									
			}
		}


	}
	$sql_update = '';
	$time_stamp = date('Y-m-d H:i:s');

	for($i= 0;$i<sizeof($match);$i++)
	{

		$sql_update .= "UPDATE `transaction_details` SET `user_id_receiver` = '{$match[$i]['R']}', `time_stamp` = '{$time_stamp}' WHERE `transaction_id` = '{$match[$i]['donor_tid']}';";
		// $sql_update .= "UPDATE transaction_details SET received_count = received_count + 1 WHERE transaction_id = '{$match[$i]['receiver_tid']}';";
		
	}
	
	$result_insert = mysqli_multi_query($connection,$sql_update);
	
	if($result_insert)
	 	$response['insert'] = 'inserted';	
	
	//print_r();

	//print_r($response); 
	//echo json_encode($response);















