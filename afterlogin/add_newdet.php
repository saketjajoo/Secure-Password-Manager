<?php

	$servername="127.0.0.1";
	$username="root";
	$password="";
	$dbname="passwordmanager";

	session_start();
	
	$connect = new mysqli("$servername",$username,$password,$dbname); 
	
	$newpass_name = $_POST['new_name'];
	$newpass_website = $_POST['new_website'];
	$newpass_email = $_POST['new_email'];
	$newpass_pass = $_POST['new_pass'];
	$strength = $_POST['passstrengthh'];
	
	$email = $_SESSION['email'];
	
	$password = '3sc3RLrpd17';
	$method = 'aes-256-cbc';
	$key = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
	$encrypted = base64_encode(openssl_encrypt($newpass_pass, $method, $key, OPENSSL_RAW_DATA, $iv));
	
	if(isset($_POST['new_submit']))
	{
		$new_addition = "INSERT INTO pass_store VALUES ('$email','$newpass_name','$encrypted','$newpass_website','$newpass_email','$key','$strength')";
		if ($connect->query($new_addition) === TRUE) 
		{
			echo "
			<script>
				alert('Password added successfully.');
				window.location.href = 'welcome.php';
			</script>
			";
		} 
		else 
		{
			echo "
			<script>
				alert('Please try again after some time.');
				window.location.href = 'welcome.php';
			</script>
			";
		}
	}
	
?>