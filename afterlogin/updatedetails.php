<?php

	$servername="127.0.0.1";
	$username="root";
	$password="";
	$dbname="passwordmanager";
	
	session_start();

	$connect = new mysqli("$servername",$username,$password,$dbname); 
	
	$uname = $_POST['chhuname'];
	$pass = $_POST['chhpwd'];
	$pass = md5($pass);
	$email = $_SESSION['email'];
	
	if($uname=='')
	{
		$uname = $_SESSION['username'];
		$update = "UPDATE `pass_login` SET `password`='$pass' WHERE username='$uname'";
	
		if ($connect->query($update) === TRUE) 
		{
			echo "
			<script>
				alert('Password changed successfully. Please login again.');
				window.location.href='logout.php';
			</script>
			";
		}
	
	}
	else
	{
		$update = "UPDATE `pass_login` SET `username`='$uname' WHERE email='$email'";
	
		if ($connect->query($update) === TRUE) 
		{
			echo "
			<script>
				alert('User ID changed successfully. Please login again.');
				window.location.href='logout.php';
			</script>
			";
		}
	
	}

?>