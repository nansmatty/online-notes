
<!-- This file receives: user_id generated key and reset password, password1 and password2 -->
<!-- This file then resets password for user_id if all checks are correct -->

<?php

session_start();
include 'connection.php';

function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
	echo "";
}
set_error_handler("errorHandler");

// If user_id or activation key is missing
if (!isset($_POST['user_id']) || !isset($_POST['key'])) {
	// 	Print error message
	echo "<div class='alert alert-danger'>There was an error. Please click on the link you received by email.</div>";
	exit();	
}
// 	Store them in two variables
$user_id = $_POST['user_id']);
$key = $_POST['key']);

// 	Define a time variables now minus 24hours
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

// 	if combination does not exists
$count = mysqli_num_rows($result);
if ($count !== 1) {

	// 	print the error message
	echo "<div class='alert alert-danger'>Wrong details. Please try again.</div>";
	exit();
}
// 	Define error message
$missingPassword = "<p><strong>Please enter a password!</strong></p>";
$invalidPassword = "<p><strong>Your password should be contain one capital letter and one number!</strong></p>";
$differentPassword = "<p><strong>Passwords does not match!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password</strong></p>";

// 	Get user inputs password1 and password2

if (empty($_POST["password"])) {		
	$errors .= $missingPassword;
} elseif (!preg_match("/^.*(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST["password"])) {

	$errors .= $invalidPassword;
} else {		
	$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
	if (empty($_POST["password2"])) {		
		$errors .= $missingPassword2;
	}
	$password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
	if ($password !== $password2) {
		$errors .= $differentPassword;
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
$password =mysqli_real_escape_string($link, $password);
$password = hash('sha256', $password);
$user_id = mysqli_real_escape_string($link, $password)

//Run Query: Update Users password in the users table

$sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id' LIMIT 1";

$result = mysqli_query($link, $sql);

if (mysqli_affected_rows($link == 1)) {

	echo "<div class='alert alert-success'>Your password has been updated successfully! <strong><a href='index.php'>Log In.</a></strong></div>";
 
} else {

	echo "<div class='alert alert-danger'>Unable to reset password. Please try again later.</div>";

}

//Set the key status to "used" in the forgotpassword table to prevent the key from being used twice

$sql = "UPDATE forgotpassword SET status = 'used' WHERE user_id = '$user_id' AND rkey = '$key' LIMIT 1";
$result = mysqli_query($link, $sql);

?>