<?php session_start(); ?>
<?php require_once 'db_connect.php'?>
<?php 
if ( !isset($_SESSION["name"]) ){ //session not found, user not logged in
	if ( isset($_POST['email']) && isset($_POST['password']) ) {
		$email=htmlentities($_POST['email']);
		$password=htmlentities($_POST['password']);
		
		if ( !empty($email) && !empty($password) ){ // not logged in, valid attempt to login, need to send him a session cookie
		
			$email = mysqli_real_escape_string($conn, $email);
			$password = mysqli_real_escape_string($conn, $password);

			$sql = "SELECT user_id, name, password FROM user_profiles WHERE email= '{$email}'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) { // match found in username
				// output data of each row
				while($row = mysqli_fetch_assoc($result)) {
					$hashed_password = crypt($password, $row["password"]);
					if ($hashed_password == $row["password"]) {//match found in password
						$_SESSION['user_id']= $row["user_id"]; 
						$_SESSION['name']= $row["name"]; 
						$_SESSION['email']= $email; 
						header('Location: profile.php');
					} else { //username matched but password didnt match
						echo "send no cookie";
					}
				}
			} else { // no match found in username
				echo "0 results";
			}
			
			
		} else { // all 2 fields might not have content in them 
			//echo "Fill in all the fields of the signup form, please?";
			header('Location: index.php');
		}
	} else { //all 2 fields not set or someone is trying to access this page by writing down its link
	  //echo "Why bruh, why? Why try to access a page that is not meant to be yours? Why why why?";
	  header('Location: index.php');
	}
} else { //session file found
	header('Location: profile.php'); //since session file found, login as user
}
?>
<?php
if (isset($conn)){
	mysqli_close($conn);
}
?>