<?php session_start(); ?>
<?php require_once 'db_connect.php';?>
<?php 
if ( isset($_POST['correct_or_not_0']) && isset($_POST['pass_task_id']) ) {
	$correct_or_not_0=$_POST['correct_or_not_0'];
	$pass_task_id=$_POST['pass_task_id'];

	
	if ( !empty($correct_or_not_0) && !empty($pass_task_id) ){ //later on, set to checking whether it is 'yes' || 'no'
		
		// we have a submission (it could be any state), so first mark task as resolved
		$sql = "UPDATE task_table SET resolved_flag=1,resolving_user_id={$_SESSION['user_id']} WHERE task_id= {$pass_task_id}";
		if (mysqli_query($conn, $sql)) {
			//echo "Record updated successfully";
		} else {
			echo "task update failed: " . mysqli_error($conn);
		}

		if ( isset($_POST['pass_score']) && isset($_POST['pass_level']) ) {
			$pass_score=$_POST['pass_score'];
			$pass_level=$_POST['pass_level'];

			$sql = "UPDATE user_profiles SET score={$pass_score},level={$pass_level} WHERE user_id= {$_SESSION['user_id']}";
			if (mysqli_query($conn, $sql)) {
				//echo "Record updated successfully";
			} else {
				echo "score/level update failed: " . mysqli_error($conn);
			}
		} else{
			echo "score or level not set";
		}
		
		
		
		//pull out the task in question, we'll need to create a new task based on it
		$sql = "SELECT sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number FROM task_table WHERE task_id= {$pass_task_id}";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) == 1) {
			// get the data on $row variable
			$row = mysqli_fetch_assoc($result);
			//echo "task id: " . $row["sentence_id"];
			/*
			while($row = mysqli_fetch_assoc($result)) {
				echo "task id: " . $row["task_id"]. " <br>sentence id: " . $row["sentence_id"]." <br>current string: " . $row["current_string"]." <br>current state: " . $row["current_state"]." <br>resolved flag: " . $row["resolved_flag"]." <br>iteration_number: " . $row["iteration_number"]. "<br><br>";
			   
			}  */
		} else {
			echo "task could not be pulled from database or there are more than one rows of tasks found.";
		}
		
		if ($correct_or_not_0=="yes"){ // sentence has been marked correct, so add a new task and iteration++
			//echo "yes received";
			//echo $pass_task_id;
			$iteration=$row["iteration_number"]+1;
			switch ($row["current_state"]) {
				case 0:
					$next_state = 1;
					$next_resolved_flag =0;
					break;
				case 1:
					$next_state = 2;
					$next_resolved_flag =1; //it is confirmed, no need to iterate over it again
					//add it to collection database
					
					
					break;
				default:
					break;
			}
			//echo $iteration;
			
			$sql = "INSERT INTO task_table (sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number)
			VALUES ({$row["sentence_id"]}, '{$row["current_string"]}', {$next_state}, {$next_resolved_flag}, 0, {$iteration})";
			if (mysqli_query($conn, $sql)) {
				$last_task_id = mysqli_insert_id($conn);
				echo "New task created successfully. Last inserted ID is: " . $last_task_id;
			} else {
				echo "Error with task insertion: " . $sql . "<br>" . mysqli_error($conn);
			}
			$children = array();
			$data = json_encode($children);
			echo $data;
			header('Location: play_game.php');

		} 
		elseif ($correct_or_not_0=="no"){
			//echo "no received";
			//echo $pass_task_id;
			
			if ( isset($_POST['corrected_sentence_0']) ) {
				
				$corrected_sentence_0=htmlentities($_POST['corrected_sentence_0']);
				$corrected_sentence_0 = mysqli_real_escape_string($conn, $corrected_sentence_0);
				$iteration=$row["iteration_number"]+1;
				
				
				$sql = "INSERT INTO task_table (sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number)
				VALUES ({$row["sentence_id"]}, '{$corrected_sentence_0}', 0, 0, 0, {$iteration})";
				if (mysqli_query($conn, $sql)) {
					$last_task_id = mysqli_insert_id($conn);
					echo "New task created successfully. Last inserted ID is: " . $last_task_id;
				} else {
					echo "Error with task insertion: " . $sql . "<br>" . mysqli_error($conn);
				}
				
				$sql = "UPDATE sentence_table SET sentence_latest_string='{$corrected_sentence_0}' WHERE sentence_id= {$row["sentence_id"]}";
				if (mysqli_query($conn, $sql)) {
					//echo "Record updated successfully";
				} else {
					echo "task update failed: " . mysqli_error($conn);
				}
				
				
				
				$children = array();
				$data = json_encode($children);
				echo $data;
				
				header('Location: play_game.php');
			} else{
				echo "need to make them fill corrected sentence up.";
			}
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