<?php

session_start();

include 'connection.php';

function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
	echo "";
}
set_error_handler("errorHandler");

// get the user_id
$user_id = $_SESSION['user_id'];


//define error messages
$missingCurrentPassword = "<p><strong>Please enter your Current Password!</strong></p>";
$incorrectCurrentPassword = "<p><strong>The password entered is incorrect!</strong></p>";
$missingPassword = "<p><strong>Please enter your new password!</strong></p>";
$invalidPassword = "<p><strong>Your password should be contain one capital letter and one number!</strong></p>";
$differentPassword = "<p><strong>Passwords does not match!</strong></p>";
$missingPassword2 = "<p><strong>Please confirm your password</strong></p>";


//check for errors

if (empty($_POST['currentpassword'])) {
	
	$errors .= $missingCurrentPassword;
	
}else {

	$currentPassword = $_POST['currentpassword'];
	$currentPassword = filter_var($currentPassword, FILTER_SANITIZE_STRING);
	$currentPassword = mysqli_real_escape_string($link, $currentPassword);
	$currentPassword = hash('sha256', $currentPassword);

	//check the password is correct or not

	$user_id = $_SESSION['user_id'];
	$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
	$result = mysqli_query($link, $sql);

	$count = mysqli_num_rows($result);
	if ($count !== 1) {

		echo "<div class='alert alert-danger'>There was a problem running the query</div>";
	    
	}else{
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	    if ($currentPassword != $row['password']) {

			$errors .= $incorrectCurrentPassword;
	    }
	}
	if (empty($_POST["newpassword"])) {		
		$errors .= $missingPassword;
	} elseif (!preg_match("/^.*(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $_POST["newpassword"])) {

		$errors .= $invalidPassword;
	} else {		
		$password = filter_var($_POST["newpassword"], FILTER_SANITIZE_STRING);
		if (empty($_POST["confirmpassword"])) {		
			$errors .= $missingPassword2;
		}else{
			$password2 = filter_var($_POST["confirmpassword"], FILTER_SANITIZE_STRING);
			if ($password !== $password2) {
				$errors .= $differentPassword;
			}
		}	
	}
}

//If there are any error print error message
if (!empty($errors)) {
	$resultMessage = "<div class='alert alert-danger'>". $errors ."</div>";
	echo $resultMessage;
}else{

	$password =mysqli_real_escape_string($link, $password);
	$password = hash('sha256', $password);

	$sql = "UPDATE users SET password = '$password' WHERE user_id = '$user_id'";
	$result = mysqli_query($link, $sql);

	if (!$result) {
		
		echo "<div class='alert alert-danger'>There was an error updating the new password in the database!</div>";
	}else{

		echo "<div class='alert alert-success'>Your password has been updated successfully!</div>";

	}
}

?>