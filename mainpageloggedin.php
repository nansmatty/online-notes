<?php

  session_start();

  if (empty($_SESSION['user_id'])) {

    header("location: index.php");

  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Notes</title>
    <link href="css/bootstrap/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css">
    <style type="text/css">
      #container{ 
        margin-top: 120px; 
      }
      #notepad, #allnotes, #done, .delete{
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
      .noteheader{
        border: 1px solid black;
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        padding: 0 10px;
        background: linear-gradient(#fff, #eceae7);
      }
      .text{
        font-size: 20px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
      }
       .timetext{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
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
            <li><a href="profile.php">Profile</a></li>
            <li><a href="">Help</a></li>
            <li><a href="">Contact Us</a></li>
            <li class="active"><a href="">My Notes</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Logged in as <b><?php echo $_SESSION['username']; ?></b></a></li>
            <li><a href="index.php?logout=1">Logout</a></li>
          </ul>
        </div>
      </div>      
    </nav>

    <!--Container ID-->
    <div class="container" id="container">
      <!-- alert message -->
      <div id="alert" class="alert alert-danger collapse">
        <a class="close" data-dismiss="alert">&times;</a>
        <p id="alertContent"></p>
      </div>
      <div class="col-md-offset-3 col-md-6">
        <div class="button">
          <button id="addnotes" type="button" class="btn btn-info btn-lg">Add Notes</button>
          <button id="edit" type="button" class="btn btn-info btn-lg pull-right">Edit</button>
          <button id="done" type="button" class="btn green btn-lg pull-right">Done</button>
          <button id="allnotes" type="button" class="btn btn-info btn-lg">All Notes</button>
        </div>
        <div id="notepad">
          <textarea rows="10"></textarea>
        </div>
        <div id="notes" class="notes">
          <!--Ajax call to php-->
        </div>
      </div>
    </div>  

    <!--Footer-->

    <div class="footer">
      <div class="container">
        <p>Nansdeveloper.com Copyright &copy; 2015-<?php $today = date("Y"); echo $today;?></p>
      </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="mynotes.js"></script>
  </body>
</html>