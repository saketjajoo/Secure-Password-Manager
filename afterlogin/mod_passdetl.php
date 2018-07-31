<?php

	$servername="127.0.0.1";
	$username="root";
	$password="";
	$dbname="passwordmanager";

	session_start();
	
	$connect = new mysqli("$servername",$username,$password,$dbname); 
	
	$modpass_name = $_POST['mod_name'];
	$modpass_website = $_POST['mod_website'];
	$modpass_pass = $_POST['mod_pass'];
	$modpass_prevname = $_POST['mod_prev_name'];
	
	$email = $_SESSION['email'];
	
	$password = '3sc3RLrpd17';
	$method = 'aes-256-cbc';
	$key='';
	//$key = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
	$key_select = "SELECT passkey FROM pass_store WHERE email_user='$email'";
	$result = $connect->query($key_select);
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$key = $row['passkey'];
		}
	}
	//echo $key;
	$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
	$encrypted = base64_encode(openssl_encrypt($modpass_pass, $method, $key, OPENSSL_RAW_DATA, $iv));
	
	
	if(isset($_POST['mod_submit']))
	{
		$new_addition = "UPDATE pass_store SET name='$modpass_name', password='$encrypted', website='$modpass_website' , passkey='$key' WHERE email_user='$email' AND name='$modpass_prevname'";
		if ($connect->query($new_addition) === TRUE) 
		{
			echo "
			<script>
				alert('Details modified successfully.');
				window.location.href = 'welcome.php';
			</script>
			";
		} 
		else 
		{
			echo "
			<script>
				alert('Please try again after some time.');
				//window.location.href = 'welcome.php';
			</script>
			";
		}
	}	
?>