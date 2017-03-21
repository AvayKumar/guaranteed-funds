<?php
session_start();

 if(!isset($_SESSION['u_id']))
	{
		$response['status'] = 'false';
		$response['session'] = 'session_not_set';
		die(json_encode($response));
	}

require './require/connection.inc.php';

$response = array();

$sql_passCheck = "SELECT user_password FROM user WHERE user_id = '{$_SESSION['u_id']}'";
$result_passCheck = mysqli_query($connection,$sql_passCheck);

$row = mysqli_fetch_assoc($result_passCheck);

if(password_verify(trim($_POST['curr_pass']), $row['user_password']) ) {
	$response['log'] = 'Correct password';
	$response['state'] = 'true';
}
else 
{
	$response['log'] = 'Incorrect password';
	$response['state'] = 'false';
	die(json_encode($response));
}

if(password_verify(trim($_POST['new_pass']), $row['user_password']) ) 
{
	$response['log'] = 'Choose different password';
	$response['state'] = 'false';
	die(json_encode($response));
}

$pass_new = password_hash(trim($_POST['new_pass']), PASSWORD_DEFAULT);


$sql_pwd = "UPDATE `user` SET `user_password` = '{$pass_new}' WHERE `user_id` = '{$_SESSION['u_id']}'";
$result_pwd = mysqli_query($connection,$sql_pwd);

if($result_pwd)
	{ 
		$response['log'] = 'Password changed successfully';
		$response['state'] = 'true';
	}

echo json_encode($response);

?>