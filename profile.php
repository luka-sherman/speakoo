<?php session_start(); ?>
<?php require_once 'db_connect.php';?>

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
        <style>
			table {
			    font-family: arial, sans-serif;
			    border-collapse: collapse;
			    width: 100%;
			}

			td, th {
			    border: 1px solid #dddddd;
			    text-align: left;
			    padding: 8px;
			}

			tr:nth-child(even) {
			    background-color: #dddddd;
			}
		</style>
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
				<li><a href="play_game.php">Play Game Control</a></li>
                <li><a href="play_game_car.php">Play Game Treatment</a></li>
			  </ul>
			  
			  <ul class="nav navbar-nav navbar-right">
				<li><a href="logout.php">Logout</a></li>
			  </ul>
			</div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="container-fluid">
			<h2>Welcome, <?php echo $_SESSION["name"];?>, to Speakoo!</h2>
			<div class="row">
				<div class="col-md-8">User Notifications</div>
				<div class="col-md-4">
					<h3>Leaderboard</h3>
					<table>
						  <tr>
						    <th>User ID</th>
						    <th>Name</th>
						    <th>Score</th>
						    <th>Level</th>
						  </tr>
					<?php 
					$sql = "SELECT user_id, name, score, level FROM user_profiles";

					$result = mysqli_query($conn, $sql);

					if (mysqli_num_rows($result) > 0) {
					    // output data of each row
					    while($row = mysqli_fetch_assoc($result)) {
					    	echo "<tr>";
					    	echo "<td>".$row["user_id"]."</td>";
					    	echo "<td>".$row["name"]."</td>";
					    	echo "<td>".$row["score"]."</td>";
					    	echo "<td>".$row["level"]."</td>";
					        echo "</tr>";
					    }
					} else {
					    echo "0 results";
					}

					?>    
					</table>
				</div>
			</div>
			
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