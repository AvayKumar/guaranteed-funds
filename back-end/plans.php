<?php
session_start();
$response = array();
$response['status'] = '';
$response['message'] = '';
$response['route_to_dashboard'] = 'false';

if(!isset($_SESSION['u_id'])) {
		$response['status'] = 'false';
		$response['message'] = 'session_not_set';
		die(json_encode($response));
}

$response['status'] = 'true';
$response['message'] = 'session_set';	



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

if(isset($_POST['package']))
{
	$sql_package_status = "SELECT * FROM transaction_details WHERE user_id_donor = '{$_SESSION['u_id']}' AND amount ='{$_POST['package']}' AND received_count <'2'";	
	$result_package_status = mysqli_query($connection,$sql_package_status);

	if(mysqli_num_rows($result_package_status))
		$response['message'] = "choose_another_package";//$_POST['package'];//'package_empty';
	else{
		$response['route_to_dashboard'] = 'true';
		$time_stamp = date('Y-m-d h:i:s');
		$sql_insert_donation = "INSERT INTO transaction_details (`user_id_donor`, `amount`, `time_stamp`) VALUES ('{$_SESSION['u_id']}','{$_POST['package']}' , '{$time_stamp}')";
		$result_insert_donation = mysqli_query($connection,$sql_insert_donation);		
	}
}

echo json_encode($response);


	
?>
