<?php

//Start session
session_start();
//Connect to the database
include 'connection.php';

//check user inputs
	//Define error message
		$missingUsername = "<p><strong>Please enter a username!</strong></p>";
		$missingEmail = "<p><strong>Please enter your email address!</strong></p>";
		$invalidEmail = "<p><strong>Please enter a valid email address!</strong></p>";
		$missingPassword = "<p><strong>Please enter a password!</strong></p>";
		$invalidPassword = "<p><strong>Your password should be contain one capital letter and one number!</strong></p>";
		$differentPassword = "<p><strong>Passwords does not match!</strong></p>";
		$missingPassword2 = "<p><strong>Please confirm your password</strong></p>";
	//Get username, email, password, password2

	// Error Handeling
	function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
		echo "";
	}
	set_error_handler("errorHandler");


	//Get username
	if (empty($_POST["username"])) {		
		$errors = $missingUsername;
	} else {		
		$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	}
	//Get email
	if (empty($_POST["email"])) {		
		$errors .= $missingEmail;
	} else {		
		$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors .= $invalidEmail;
		}
	}
	//Get password
	if (empty($_POST["password"])) {		
		$errors .= $missingPassword;
	} elseif (!preg_match("/^.*(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST["password"])) {

		$errors .= $invalidPassword;

	} else {		
		$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
		if (empty($_POST["password2"])) {		
			$errors .= $missingPassword2;
		} else{

			$password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
			if ($password != $password2) {
				$errors .= $differentPassword;
			}
		}
	}
	//If there are any error print error message

	if (!empty($errors)) {
		$resultMessage = "<div class='alert alert-danger'>". $errors ."</div>";
		echo $resultMessage;
		exit();
	}

//No errors
	//Prepare variable for the queries

$username = mysqli_real_escape_string($link, $username);
$email = mysqli_real_escape_string($link, $email);
$password =mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);


	//If username exists in the users table print error

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($link, $sql);
if (!$result) {
	echo "<div class='alert alert-danger'>Error running in query! :". mysqli_error($link). "</div>";
	exit();
}
$results = mysqli_num_rows($result);
if ($results) {
	echo "<div class='alert alert-danger'>That username is already registered. Do you want to log in?</div>";
	exit();
}
	//if email exists in the users table print error

$sql = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($link, $sql);
if (!$result) {
	echo "<div class='alert alert-danger'>Error running in query!:". mysqli_error($link). "</div>";
	exit();
}
$results = mysqli_num_rows($result);
if ($results) {
	echo "<div class='alert alert-danger'>That email is already registered. Do you want to log in?</div>";
	exit();
}
	//Create a unique activation code

$activationKey = bin2hex(openssl_random_pseudo_bytes(16));

	//Insert User details and activation code in the users table

$sql = "INSERT INTO users (username, email, password, activation) VALUES ('$username', '$email', '$password', '$activationKey')";

$result = mysqli_query($link, $sql);
if (!$result) {
	echo "<div class='alert alert-danger'>There was an error inserting the users details in the database!:". mysqli_error($link). "</div>";
	exit();
}

	//Send the user an email with a link to activate.php with their email and activation code

$message = "Please click on this link to activate your account:\n\n";
$message .= "http://mynotes.thecompletewebhosting.com/activate.php?email=".urlencode($email).							"&key=$activationKey";

if (mail($email, 'Confirm your Registration', $message, 'From:'.'narayanmaitysp1997@gmail.com')) {
	
	echo "<div class='alert alert-success'>Thanks for your registration! A confirmation email has been sent to $email. Please click on the activation link to activate your account </div>";

}


?>