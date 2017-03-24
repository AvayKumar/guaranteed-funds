<?php
session_start();

$response['route_to_dashboard'] = 'false';
$response['session'] = '';

if(!isset($_SESSION['u_id'])) {
		$response['status'] = 'false';
		$response['session'] = 'session_not_set';
		die(json_encode($response));
}

$response['status'] = 'true';
$response['session'] = 'session_set';	

//$response['value'] = $_SESSION['u_id'];

require './require/connection.inc.php';

if(isset($_POST['package']))
{
	$sql_package_status = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND amount ='{$_POST['package']}' AND received_count <'2'";	
	$result_package_status = mysqli_query($connection,$sql_package_status);

	if(mysqli_num_rows($result_package_status))
		$response['message'] = 'You can\'t choose '.$_POST['package'].' package right now. For more infor see our FAQs';
	else{
		$response['route_to_dashboard'] = 'true';
		$time_stamp = date('Y-m-d H:i:s');
		$sql_insert_donation = "INSERT INTO transaction_details (`user_id_donor`, `amount`, `time_stamp`) VALUES ('{$_SESSION['u_id']}','{$_POST['package']}' , '{$time_stamp}')";
		$result_insert_donation = mysqli_query($connection,$sql_insert_donation);		
	}
}

echo json_encode($response);


	
?>
