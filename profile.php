<?php

  session_start();

  if (empty($_SESSION['user_id'])) {
    header("location: index.php");
  }

  include 'connection.php';

  function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
    echo "";
  }
  set_error_handler("errorHandler");


  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
  $result = mysqli_query($link, $sql);

  $count = mysqli_num_rows($result);

  if ($count == 1) {

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $username = $row['username'];
    $email = $row['email'];
  }else{
    echo "There was an error retrieving the username and email from the database !";
  }



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
      #container{
        margin-top: 100px; 
      }
      #notepad, #allnotes, #done{
        display: none;
      }
      .button{
        margin-bottom: 20px;
        outline: none;
      }
      textarea{
        width: 100%;
        max-width: 100%;
        font-size: 1em;
        line-height: 1.5em;
        border-left-width: 20px;
        border-color: #CA3DD9;
        color: #CA3DD9;
        background-color: #fbefff;
        padding: 10px;
      }
    </style>
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
            <li class="active"><a href="">Profile</a></li>
            <li><a href="">Help</a></li>
            <li><a href="">Contact Us</a></li>
            <li><a href="mainpageloggedin.php">My Notes</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Logged in as <b><?php echo $username; ?></b></a></li>
            <li><a href="index.php?logout=1">Logout</a></li>
          </ul>
        </div>
      </div>      
    </nav>

    <!--Container ID-->
    <div class="container" id="container">
      <div class="col-md-offset-3 col-md-6">
        <h2>General Account Settings:</h2>
        <div class="table-responsive">
          <table class="table table-hover table-condensed table-bordered">
            <tr data-target="#updateusername" data-toggle="modal">
              <td>Username</td>
              <td><?php echo $username; ?></td>
            </tr>
            <tr data-target="#updateemail" data-toggle="modal">
              <td>Email</td>
              <td><?php echo $email; ?></td>
            </tr>
            <tr data-target="#updatepassword" data-toggle="modal">
              <td>Password</td>
              <td>Hidden</td>
            </tr>
          </table>
        </div>
      </div>
    </div>


    <!--Update Username-->
    <form method="post" id="updateusernameform">
      <div class="modal" id="updateusername" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Edit Username:</h4>
            </div>
            <div class="modal-body">
              <!--update message from PHP file-->
              <div id="updatemessage"></div>
              <div class="form-group">
                <label for="username">Username:</label>
                <input class="form-control" type="text" name="username" id="username" maxlength="50" value="<?php echo $username; ?>">
              </div>           
            </div>
            <div class="modal-footer">
              <input class="btn green" type="submit" name="submit" value="Submit">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
   </form>

   <!--Update Email-->
    <form method="post" id="updateemailform">
      <div class="modal" id="updateemail" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Enter New Email:</h4>
            </div>
            <div class="modal-body">
              <!--Update message from PHP file-->
              <div id="updateEmailmessage"></div>
              <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="text" name="email" id="email" maxlength="50" value="<?php echo$email; ?>">
              </div>           
            </div>
            <div class="modal-footer">
              <input class="btn green" type="submit" name="submit" value="Submit">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
   </form>

    <!--Update Password-->
    <form method="post" id="updatepasswordform">
      <div class="modal" id="updatepassword" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button class="close" data-dismiss="modal">
              &times;
              </button>
              <h4 id="myModalLabel">Enter Current and New Password:</h4>
            </div>
            <div class="modal-body">
              <!--update message from PHP file-->
              <div id="updatepasswordmessage"></div>
              <div class="form-group">
                <label for="currentpassword" class="sr-only">Current Password:</label>
                <input class="form-control" type="password" name="currentpassword" id="currentpassword" placeholder="Your Current Password" maxlength="50">
              </div>
              <div class="form-group">
                <label for="newpassword" class="sr-only">New Password:</label>
                <input class="form-control" type="password" name="newpassword" id="newpassword" placeholder="New Password" maxlength="50">
              </div>
              <div class="form-group">
                <label for="confirmpassword" class="sr-only">Confirm Password:</label>
                <input class="form-control" type="password" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" maxlength="50">
              </div>           
            </div>
            <div class="modal-footer">
              <input class="btn green" type="submit" name="submit" value="Submit">
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

    <script src="jquery-3.3.1.min.js"></script>
    <script src="bootstrap.js"></script>
    <script src="updateProfile.js"></script>
  </body>
</html>
