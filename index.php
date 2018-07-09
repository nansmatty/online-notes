<?php

  session_start();
  include 'connection.php';

  //Logout
  include 'logout.php';

  //remember me file
  include 'rememberMe.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Notes</title>
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>

    <!--Navigaion Bar-->

    <nav role="navigation" class="navbar navbar-custom navbr-fixed-top">
      <div class="container-fluid">        
        <div class="navbar-header">
          <a class="navbar-brand">Online Notes</a>
          <button type="button" class="navbar-toggle" data-target="#navbarCollapse" data-toggle="collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbarCollapse" >          
          <ul class="nav navbar-nav">
            <li class="active"><a href="">Home</a></li>
            <li><a href="">Help</a></li>
            <li><a href="">Contact Us</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#loginModal" data-toggle="modal">Login</a></li>
          </ul>
        </div>
      </div>      
    </nav>

    <!--Jumbotron with signup button-->

    <div class = "jumbotron" id="myContainer">
      <h1>Online Notes App</h1>
      <p>Your notes with you wherever you go.</p>
      <p>Easy to use, protects all your notes!</p> 
      <button type="button" class="btn btn-lg green signup" data-target="#signupModal" data-toggle="modal">Sign up-It's free</button>
    </div>

    <!--Login Form-->
    <form method="post" id="loginform">
      <div class="modal" id="loginModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Login:</h4>
            </div>
            <div class="modal-body">
              <!--Sign Up message from PHP file-->
              <div id="loginmessage"></div>
             <div class="form-group">
                <label for="email" class="sr-only">Email:</label>
                <input class="form-control" type="email" name="loginemail" id="loginemail" placeholder="Email" maxlength="50">
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Password:</label>
                <input class="form-control" type="password" name="loginpassword" id="loginpassword" placeholder="Password" maxlength="20" minlength="8">
              </div>            
            </div>
            <div class="checkbox" id="checkbox">
              <label style="padding-left: 35px;">
                <input type="checkbox" name="rememberme" id="rememberme"> Remember Me
            </label>
            <a class="pull-right" style="cursor: pointer; padding-right:15px;" data-dismiss="modal"data-target="#forgotpasswordModal" data-toggle="modal">Forget Password?</a>
            </div>
            <div class="modal-footer">              
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
              <input class="btn green" type="submit" name="submit" value="Login">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
   </form>

   <!--Forget Password Form-->
    <form method="post" id="forgotpasswordform">
      <div class="modal" id="forgotpasswordModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Forgot Password? Enter your Email Address:</h4>
            </div>
            <div class="modal-body">
              <!--Sign Up message from PHP file-->
              <div id="forgotpasswordmessage"></div>
             <div class="form-group">
                <label for="email" class="sr-only">Email:</label>
                <input class="form-control" type="email" name="forgetpasswordemail" id="forgetpasswordemail" placeholder="Email" maxlength="50">
              </div>           
            </div>
            <div class="modal-footer">              
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-target="#signupModal" data-toggle="modal">Register</button>
              <input class="btn green" type="submit" name="submit" value="Submit">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
   </form>

    <!--SignUp Form-->
   <form method="post" id="signupform">
      <div class="modal" id="signupModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Sign up today and Start using our Online Notes App!</h4>
            </div>
            <div class="modal-body">
              <!--Sign Up message from PHP file-->
              <div id="signupmessage"></div>
              <div class="form-group">
                <label for="username" class="sr-only">Username:</label>
                <input class="form-control" type="text" name="username" id="username" placeholder="Username" maxlength="30">
              </div>
              <div class="form-group">
                <label for="email" class="sr-only">Email:</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email Address" maxlength="50">
              </div>
              <div class="form-group">
                <label for="password" class="sr-only">Choose a password:</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Choose a password" maxlength="20" minlength="8">
              </div>
              <div class="form-group">
                <label for="password2" class="sr-only">Confirm password:</label>
                <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirm password" maxlength="20" minlength="8">
              </div>              
            </div>
            <div class="modal-footer">              
              <input class="btn green" type="submit" name="submit" value="Sign Up">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
   </form>

    <!--Footer-->

    <div class="footer">
      <div class="container">
        <p>Nansdeveloper.com Copyright &copy; 2015-<?php $today = date("Y"); echo $today;?></p>
      </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="index.js"></script>
  </body>
</html>