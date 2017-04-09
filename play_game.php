<?php session_start(); ?>
<?php require_once 'db_connect.php'?>

<?php
if( !isset($_SESSION["name"]) ) { // not logged in, not permitted to view the page
	//echo "who are you?"; //redirect to login later
	header('Location: index.php');
	die();
}
?>
<html>
    <head>
        <title>Speakoo | Profile</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/newstyle.css" />
        

        <!-- include JS -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.js"></script>
        <script src="js/bootstrap-rating-input.min.js" type="text/javascript"></script>
    </head>
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="profile.php">Speakoo</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav">
				<!--<li class="active dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Profile <span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="profile.php">Videos</a></li>
					<li><a href="view_information.php">Account Information</a></li>


				  </ul>
				</li>
				<li><a href="newsfeed.php">Newsfeed</a></li>
				<li><a href="recordvideo.php">Record a new video</a></li>-->
				<li><a href="play_game.php">Play Game</a></li>
			  </ul>
			  
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Logout</a></li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="container-fluid">
			<!--<h2>Welcome, <?php //echo $_SESSION["name"];?>, to Speakoo!</h2>-->
			<h3>Grammar Correction</h3>
			<?php
			$sql = "SELECT task_id, sentence_id, current_string, current_state, resolved_flag, resolving_user_id, iteration_number FROM task_table";
			
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				// output data of each row
				$flag_row_accessed=0;
				while($row = mysqli_fetch_assoc($result)) {
					
					if(!$row["resolved_flag"] ){ //later on make sure this guy has not touched this sentence before, this is the condition for finding the task to deliver in the games page 
						//echo "task found for this user";
						//echo $row["task_id"];
						
						echo "Is the highlighted sentence below grammatically accurate?<br><br>";

						$sql = "SELECT doc_id FROM sentence_table WHERE sentence_id={$row["sentence_id"]}";
						$result = mysqli_query($conn, $sql);
						$row_doc_id = mysqli_fetch_assoc($result);
						$sql = "SELECT sentence_id, sentence_string, sentence_latest_string FROM sentence_table WHERE doc_id={$row_doc_id["doc_id"]}";
						$result = mysqli_query($conn, $sql);
						if (mysqli_num_rows($result) > 0) {
							// output data of each row
							while($row_paste_sentence = mysqli_fetch_assoc($result)) {
								if ($row_paste_sentence["sentence_id"]!=$row["sentence_id"]){
									//echo $row_paste_sentence["sentence_latest_string"].". "; // this one shows recentmost string
									echo $row_paste_sentence["sentence_string"].". ";
								}elseif($row_paste_sentence["sentence_id"]==$row["sentence_id"]) {
									echo "<b><em>".$row["current_string"].".</em></b> ";
								}
							}
						} else {
							echo "0 results";
						}
						
						?>
						<form method="POST" action="handle_user_submission.php">
						  <br><input type="radio" name="correct_or_not_0" id="yes_check" value="yes" checked> Yes<br>
						  <input type="radio" name="correct_or_not_0" id="no_check" value="no"> No<br><br>
						  <!--<span id="cor_sen_0" >Please correct the sentence: <input type="textbox" name="corrected_sentence_0" ><br><br> </span> -->
						  <span id="cor_sen_0" >Please correct the sentence:<br><textarea name="corrected_sentence_0" rows="4" cols="50"><?php echo $row["current_string"];?></textarea><br><br> </span>
						  <input type="hidden" name="pass_task_id" value="<?php echo $row["task_id"]; ?>">
						  <input type="submit" class="btn btn-default" value="Submit"/>
						</form>
						<script>
						$(document).ready(function () {
							$("#cor_sen_0").hide();
							$("#no_check").click(function () {
								$("#cor_sen_0").show();
							});
							$("#yes_check").click(function () {
								$("#cor_sen_0").hide();
							});
						});
						</script>
						<?php
						$flag_row_accessed=1; // if this 'if' condition is met even once, then flag goes to 1, hence there has been some update  
 						return; // we want to stop iterating through the task_table once we find a task that this user is allowed to resolve
					} else {
						//This particular row of task_table doesn't have any task for this user
					}
				}
				if (!$flag_row_accessed){ //task table not empty, while loop has ended, yet flag is still zero, which means none of the rows was resolved, which means we have reached the end 
					echo "Congrts! There is no more sentence to be corrected!";
				}
			} else {
				echo "task table empty";
			}
			?>
			
		</div> <!--container-fluid ends-->	
		
		<script src="wordcloudjs/d3.min.js"></script>
		<script src="wordcloudjs/cloud.min.js"></script>
	</body>
</html>	

<?php
if (isset($conn)){
	mysqli_close($conn);
}
?>