<!DOCTYPE html>
<html>
<head>
    <title>Speakoo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
  
<body>
    <nav class="navbar navbar-inverse" style="border-radius: 0px;">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Speakoo</a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Link</a></li> -->
            
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-default btn-md" style="background-color: #d0d0d0; margin-top: 6px; margin-right: 5px;" data-toggle="modal" data-target="#myModal">
              Login
            </button>
            <button type="button" class="btn btn-default btn-md" style="background-color: #d0d0d0;margin-top: 6px;" data-toggle="modal" data-target="#myModalsubmit">
              Signup
            </button>
          </ul>
            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Login</h4>
                  </div>
                  <form method="POST" action="login.php">
                  <div class="modal-body">
                    
                        <p>Email: <input type="email" name="email" required></p>
						<p>Password: <input type="password" required name="password"/></p>
                        
						
                    
                  </div>
                  <div class="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <input type="submit" class="btn btn-default" value="Login"/>
                  </div>
                  </form>
                </div>
              </div>
            </div>

            

            <!-- Modal -->
            <div class="modal fade" id="myModalsubmit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Signup</h4>
                  </div>
                  <form method="POST" action="signup.php">
                  <div class="modal-body">
                    
                        <p>Name: <input type="text" required name="name"/></p>
                        <p>Email: <input type="Email" required name="email"></p>
                        <p>Phone Number: <input type="text" required name="phone_number"/></p>
                        <p>Date of birth: <input type="date" required name="dob"></p>
                        <p>Password: <input type="password" id="password" required name="password"/></p>
                        <p>Confirm Password: <input type="password" id="confirm_password" required name="confirm_password"/></p>
                        
                        <script>
							var password = document.getElementById("password"), confirm_password = document.getElementById("confirm_password");

							function validatePassword(){
							  if(password.value != confirm_password.value) {
								confirm_password.setCustomValidity("Passwords Don't Match");
							  } else {
								confirm_password.setCustomValidity('');
							  }
							}

							password.onchange = validatePassword;
							confirm_password.onkeyup = validatePassword;
						</script>
                        
                    
                  </div>
                  <div class="modal-footer">
                    
                    <input type="submit" class="btn btn-default" value="Signup"/>
                  </div>
                  </form>
                </div>
              </div>
            </div>
          
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

	<div class="container">
	The homepage details go here.
	</div>
	
	
	
  

   
 
 
<!-- Include all compiled plugins as needed -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

</body>
</html>
