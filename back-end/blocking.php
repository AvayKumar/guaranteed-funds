<?php
	
	require './require/connection.inc.php';

	$TIME_INTERVAL = 'PT1H';


	$sql_timer = "SELECT a.time_stamp AS `time_stamp`, u.user_id AS `user_id` FROM `transaction_details` a JOIN `user` u ON a.user_id_receiver = u.user_id AND a.have_paid = '0' AND a.user_id_receiver IS NOT NULL";


	$now = date_create();

	$result_time = mysqli_query($connection, $sql_timer);

		if( $result_time ) {
			while($row = mysqli_fetch_assoc($result_time)) {

				$db_date = date_create($row['time_stamp']);
				
				$db_date->add(new DateInterval($TIME_INTERVAL));

				$diff = date_diff($db_date, $now);
				
				if(($diff->format('%R') == '+') ) {

					// Block user temporarly
					$sql_block = "UPDATE `user` SET `user_blocked` = '1' WHERE `user_id` = '{$row['user_id']}'"; 
					$res_block = mysqli_query($connection, $sql_block);
					
					$sql_block2 = "UPDATE `transaction_details` SET `user_id_receiver`= NULL WHERE `user_id_donor`='{$row['user_id']}' AND `have_paid`='0'";
			        $res_block2=mysqli_query($connection,$sql_block2);

			        $sql_block3 = "UPDATE `transaction_details` SET `user_id_receiver`=NULL WHERE `user_id_receiver`='{$row['user_id']}' AND `have_paid`='0'";
			        $res_block3 = mysqli_query($connection,$sql_block3);

					
				
				}
			}
		}

?>