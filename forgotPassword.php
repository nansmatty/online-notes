<?php 

// Start session 
session_start();

// Connect to the database
include 'connection.php';

// check user inputs
// 	Define error message

$missingEmail = "<p><strong>Please enter your email ID!</strong></p>";
$invalidEmail = "<p><strong>Please enter valid email ID!</strong></p>";

//Error Handeling

function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
	echo "";
}
set_error_handler("errorHandler");

// 	Get email
if (empty($_POST["forgetpasswordemail"])) {		
		$errors .= $missingEmail;
} else {		
	$email = filter_var($_POST["forgetpasswordemail"], FILTER_SANITIZE_EMAIL);
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors .= $invalidEmail;
	}
}
// 	Store errors in errors variable
// 	If there are any errors

if (!empty($errors)) {
	$resultMessage = "<div class='alert alert-danger'>". $errors ."</div>";
// 		print the error message
	echo $resultMessage;
	exit();
}
// 	else: No errors
// 	Prepare variable for the queries
$email = mysqli_real_escape_string($link, $email);

// 	Run query to Check if the email exists in the users table
$sql = "SELECT * FROM users WHERE email = '$email'";

$result = mysqli_query($link, $sql);

// If the email does not exist

$count = mysqli_num_rows($result);
if ($count !== 1) {

	// 	print the error message
	echo "<div class='alert alert-danger'>Email ID does not exists.</div>";
	exit();
}

// 	get the user_id
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$user_id = $row['user_id;'];

// 		Create a unique acivation code
$key = bin2hex(openssl_random_pseudo_bytes(16));

$time = time();

$status = 'pending';

// 		Insert user details and acivation code i the forgot password table

$sql = "INSERT INTO users (user_id, rkey, timer, status) VALUES ('$user_id', '$key', '$time', '$status')";

$result = mysqli_query($link, $sql);

// 		Send email with link to resetpassword.php with user id and activation code

$message = "Please click on this link to reset your password:\n\n";
$message .= "http://mynotes.thecompletewebhosting.com/resetpassword.php?user_id=$user_id&key=$key";

// 		if email sent successfully
// 			print success message

if (mail($email, 'Reset Your Password', $message, 'From:'.'narayanmaitysp1997@gmail.com')) {
	
	echo "<div class='alert alert-success'>An email has been sent to $email. Please click on the link to reset your password</div>";

}

?>