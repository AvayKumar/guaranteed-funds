<HTML>
<HEAD>
	<TITLE>Admin | Guaranteed Funds</TITLE>
</HEAD>

<BODY>
	<div>
	<FORM method = 'post' action = 'admin.php'>
		User<input type = 'text' name = 'u_name'>
		Password<input type = 'Password' name = 'password'>
		<input type = 'submit' name = 'b1' value = 'OK'>
	</FORM>
	</div>
</BODY>
</HTML>


<?php
	function authStatus(){
	require './require/connection.inc.php';
	//echo '1';
	// $sql_verify = "SELECT `password` FROM `admin` WHERE `user_name` = '{$_POST['u_name']}'";
	// $res_verify = mysqli_query($connection,$sql_verify);
	echo "?";
	if($res_verify){
		$row = mysqli_fetch_assoc($res_verify);
		echo "data";
		if(password_verify(trim($_POST['password']), $row['password']) )
			echo "valid_user";
	}
	else{
		echo "data";
	
	}

if(isset($_POST['b1'])){
	authStatus();
}	

?>