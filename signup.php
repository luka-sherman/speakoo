<?php require_once 'db_connect.php'?>
<?php 
if ( isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone_number']) && isset($_POST['dob']) && isset($_POST['password']) ) {
	$name=htmlentities($_POST['name']);
	$email=htmlentities($_POST['email']);
	$phone_number=htmlentities($_POST['phone_number']);
	$dob=htmlentities($_POST['dob']);
	$password=htmlentities($_POST['password']);
	
	if ( !empty($name) && !empty($email) && !empty($phone_number) && !empty($dob) && !empty($password) ){
		
		
		$name = mysqli_real_escape_string($conn, $name);
		$email = mysqli_real_escape_string($conn, $email);
		$phone_number = mysqli_real_escape_string($conn, $phone_number);
		$dob = mysqli_real_escape_string($conn, $dob);
		$password = mysqli_real_escape_string($conn, $password);
		
		// check if email exists in the database 
		$sql = "SELECT id, name, phone_number, dob, password FROM user_profiles WHERE email='{$email}'";
		$result = mysqli_query($conn, $sql);
		
		if (mysqli_num_rows($result) == 0) { //email not duplicate
			$salt = time().time().time().time();
			$format_and_salt = "$2y$10$".$salt;
			$hashed_password = crypt($password, $format_and_salt);
			
			$sql = "INSERT INTO user_profiles (name, email, phone_number, dob, password)
			VALUES ('{$name}', '{$email}', '{$phone_number}', '{$dob}', '{$hashed_password}' )";

			if (mysqli_query($conn, $sql)) { //query successful 
				$last_id = mysqli_insert_id($conn);
				echo "New record created successfully. Last inserted ID is: " . $last_id;
				
			} else { // error when running mysql qery
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		} else { //email duplicate 
			echo "email exists";
		}
		
	} else { // all 5 fields might not have content in them. This is never likely to happen due to form validation directly during submission
		//echo "Fill in all the fields of the signup form, please?";
		header('Location: index.php');
	}
} else { //all 5 fields not set (not likely to ever happen) or someone is trying to access this page by writing down its link
  header('Location: index.php');
}
	
?>
<?php
if (isset($conn)){
	mysqli_close($conn);
}
?>