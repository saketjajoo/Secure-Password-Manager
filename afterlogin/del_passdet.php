<?php

	$servername="127.0.0.1";
	$username="root";
	$password="";
	$dbname="passwordmanager";
	
	session_start();

	$connect = new mysqli("$servername",$username,$password,$dbname); 
	
	$delpass_name = $_POST['del_name'];
	$delpass_website = $_POST['del_website'];
	$email = $_SESSION['email'];
	
	if(isset($_POST['del_submit']))
	{
		$new_addition = "DELETE FROM pass_store WHERE email_user='$email' AND website='$delpass_website' AND name='$delpass_name'";
		
		$result = mysqli_query($connect,"select count(website) FROM pass_store WHERE email_user='$email' AND website='$delpass_website' AND name='$delpass_name'");
		$row = mysqli_fetch_array($result);
		$total = $row[0];
		if($total == 0)
		{
			echo "
			<script>
				alert('Please try again after some time.');
				window.location.href = 'welcome.php';
			</script>
			";
		}
		
		else
		{
			if ($connect->query($new_addition) === TRUE) 
			{
				echo "
				<script>
					alert('Password deleted successfully.');
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
	}
	
?>