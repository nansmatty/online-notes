
<!-- This files receives the user_id and key generated to create a new password
This form displays a form to input new password -->
<?php
	session_start();
	include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Password reset</title>
        <link href="css/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <style>
        	body{

			  	font-family: 'Arvo', serif;
			}
			h1{
                color:purple;   
            }
        </style> 

    </head>
    <body>
	<div class="container-fluid">
	    <div class="row">
	        <div class="col-sm-offset-1 col-sm-10 contactForm">
	            <h1>Reset Password:</h1>
	            <div id="resetpasswordmessage"></div>
<?php
	// If user_id and reset key is missing
	if (!isset($_GET['user_id']) || !isset($_GET['key'])) {

		echo "<div class='alert alert-danger'>There was an error. Please click on the link you received by email.</div>";
		exit();	
	}
	// 	Store  them in two variables
	$user_id = $_GET['user_id']);
	$key = $_GET['key']);

	//Define a time variable: now minus 24 hours

	$time = time() - 86400;

	// 	Prepare variables for the query

	$user_id = mysqli_real_escape_string($link, $user_id);
	$key = mysqli_real_escape_string($link, $key);

	// 	Run Query: Check combination of the user_id & key exists and less than 24hour old

	$sql = "SELECT user_id FROM forgotpassword WHERE rkey='$key' AND user_id='$user_id' AND timer>$time AND status='pending'";

	$result = mysqli_query($link, $sql);

	if (!$result) {

		// 	print the error message
		echo "<div class='alert alert-danger'>Error running the query!</div>";
		exit();
	}

	// if combination does not exists
	//Print error message

	$count = mysqli_num_rows($result);
	if ($count !== 1) {

		// 	print the error message
		echo "<div class='alert alert-danger'>Wrong details. Please try again.</div>";
		exit();
	}

	// Print reset password form with hidden user_id and key fields

	echo '
		<form method="post" id="resetpasswordform">
			<input type="hidden" name="key" value="$key">	
			<input type="hidden" name="user_id" value="$user_id">
			<div class="form-group">
				<label for="password">Enter your new Password:</label>
				<input type="password" name="password" id="password" placeholder="Enter Password" class="form-control">
			</div>
			<div class="form-group">
				<label for="password2">Re-enter Password:</label>
				<input type="password" name="password2" id="password2" placeholder="Re-enter Password" class="form-control">
			</div>
			<input type="submit" name="resetpassword" value="Reset Password" class="btn btn-success btn-lg">
		</form>
	';
?>
	        </div>
	    </div>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="bootstrap.js"></script>
    <script>

    	//Script for Ajax call to storeresetpassword.php which process the form data    	
    	//Once the form is submtted

		$("#resetpasswordform").submit(function(event){

			//prevent default php processing
			event.preventDefault();

			//collect the user data
			var dataToPost = $(this).serializeArray();
			//console.log(dataToPost);

			//send them to the forgotPassword.php file using AJAX

			$.ajax({

				url: "storeResetPassword.php",
				type: "POST",
				data: dataToPost,

				//AJAX Call Successful : show error or success message
				success: function(data){

					$("#resetpasswordmessage").html(data);
				},

				//AJAX Call Fails: show Ajax Call Error
				error: function(){
					
					$("#resetpasswordmessage").html("<div class='alert alert-danger'>There was an error with the AJAX call.Please Try again later</div>");
				}
			});
		});
    </script>

    </body>
</html>

	

	