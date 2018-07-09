<?php
	// The user is redirected to this file after clicking the link received by email and aiming at proving the own the new email address
	//link contains THREE parameters: email, new email and activation key
	session_start();
	include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Email Activation</title>
        <link href="css/bootstrap/bootstrap.css" rel="stylesheet">
        <style>
            h1{
                color:purple;   
            }
        </style> 

    </head>
        <body>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-offset-1 col-sm-10 contactForm">
            <h1>Email Activation:</h1>
<?php
	// If email and activation key is missing show an error
	if (!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])) {

		echo "<div class='alert alert-danger'>There was an error. Please click on the activation link you received by email.</div>";
		exit();	
	}
	// 	Store  them in two variables
	$email = $_GET['email']);
	$newemail = $_GET['newemail']);
	$key = $_GET['key']);

	// 	Prepare variables for the query

	$email = mysqli_real_escape_string($link, $email);
	$newemail = mysqli_real_escape_string($link, $newemail);
	$key = mysqli_real_escape_string($link, $key);

	// 	Run query: update email
	$sql = "UPDATE users SET email = '$newemail', activation2 = '0' WHERE (email = '$email' AND activation2 = '$key') LIMIT 1";

	$result = mysqli_query($link, $sql);

	// 	If query is successful, show success message and invite user to login
	if (mysqli_affected_rows($link == 1)) {

		session_destroy();
		setcookie("rememberme", "", time()-3600)
		echo "<div class='alert alert-success'>Your email has been updated.</div>";
		echo "<a href='index.php' type='button' class='btn-lg btn-success'>Log In.</a>";
	 
	} else {

		echo "<div class='alert alert-danger'>Your email could not be updated. Please try again later.</div>";

	}
?>
        </div>
    </div>
</div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="bootstrap.js"></script>
        </body>
</html>