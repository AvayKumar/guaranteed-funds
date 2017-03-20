<?php

	require './require/connection.inc.php';

	session_start();
	$response['insert'] = 'check'; 
	$num_packages = 6;
	$package = array('10000','20000','30000','50000','100000','500000');
	$match = array();
	$j = 0;
	for($i = 0; $i < $num_packages ; $i++)
	{		
		$query_donor = "SELECT `transaction_id`, `user_id_donor`, `user_id_receiver`, `amount`, `have_paid`, `received_count`, `time_stamp` 			
					   FROM transaction_details WHERE `user_id_receiver` IS NULL AND `amount` = '{$package[$i]}' ";

		$result_donor = mysqli_query($connection, $query_donor);

		$query_receiver = "SELECT `transaction_id`, `user_id_donor`, `user_id_receiver`, `amount`, `have_paid`, `received_count`, `time_stamp` FROM transaction_details WHERE `have_paid` = '1' AND `received_count` < '2' AND `amount` = '{$package[$i]}'";

		$result_receiver = mysqli_query($connection, $query_receiver);				   		
		
		while( ($row1 = mysqli_fetch_assoc($result_donor)) && ($row2 = mysqli_fetch_assoc($result_receiver) )){

				$match[$j]['amount'] = $package[$i];
				$match[$j]['receiver_tid'] = $row2['transaction_id'];
				$match[$j]['donor_tid'] = $row1['transaction_id'];
				$match[$j]['D'] = $row1['user_id_donor'];
				$match[$j]['R'] = $row2['user_id_donor'];
				$j++;
				
		}
	}
	$sql_update = '';
	$time_stamp = date('Y-m-d h:i:s');
	
	for($i= 0;$i<sizeof($match);$i++)
	{

		$sql_update .= "UPDATE `transaction_details` SET `user_id_receiver` = '{$match[$i]['R']}', `time_stamp` = '{$time_stamp}' WHERE `transaction_id` = '{$match[$i]['donor_tid']}';";
		$sql_update .= "UPDATE transaction_details SET received_count = received_count + 1 WHERE transaction_id = '{$match[$i]['receiver_tid']}';";
		
	}
	
	$result_insert = mysqli_multi_query($connection,$sql_update);
	
	$response['insert'] = $sql_update;
	//echo json_encode($response);
	
	if($result_insert)
	 	$response['insert'] = 'inserted';	
	 
	 echo json_encode($response);















