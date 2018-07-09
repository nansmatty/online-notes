<?php
	// Start session
	session_start();
	// Connect to the database

	include 'connection.php';

	// check user inputs
	// 	Define error message

	$missingEmail = "<p><strong>Please enter your email ID!</strong></p>";
	$missingPassword = "<p><strong>Please enter your password!</strong></p>";
	//$wrongEmailandPassword = "<p><strong></strong></p>";

	function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
		echo "";
	}
	set_error_handler("errorHandler");

	// 	Get email and password

	//Get email
		if (empty($_POST["loginemail"])) {		
			$errors = $missingEmail;
		} else {		
			$email = filter_var($_POST["loginemail"], FILTER_SANITIZE_EMAIL);
		}
	//Get password
		if (empty($_POST["loginpassword"])) {		
			$errors .= $missingPassword;
		} else {		
			$password = filter_var($_POST["loginpassword"], FILTER_SANITIZE_STRING);
		}

	// 	Store errors in errors variable
	// 	If there are any errors

	if (!empty($errors)) {
		$resultMessage = "<div class='alert alert-danger'>". $errors ."</div>";
	// 		print the error message
		echo $resultMessage;
	} else {
	// 	else: No errors
	// 	Prepare variable for the queries
		$email = mysqli_real_escape_string($link, $email);
		$password =mysqli_real_escape_string($link, $password);
		$password = hash('sha256', $password);

	// 		Run query: Check combination of email & password exists
		$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password' AND activation = 'activated'"; 

		$result = mysqli_query($link, $sql);

		// 		If email & password don't match print error

		$count = mysqli_num_rows($result);
		if ($count !== 1) {

			echo "<div class='alert alert-danger'>Invalid email ID & password!</div>";

		} else {

			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		//	else
		// 		log the user in: Set session variable

			$_SESSION['user_id'] = $row['user_id'];
			$_SESSION['username'] = $row['username'];
			$_SESSION['email'] = $row['email'];

		// 	If remember is not checked

			if (empty($_POST['rememberme'])) {
		//		print "success"
				echo "success";
			} else{

	// 		Create two variables $authenticator1 and $authenticator2

				$authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
				$authenticator2 = openssl_random_pseudo_bytes(20);

	// 		Store them in a cookie

				function f1($a, $b){

					$c = $a . "," . bin2hex($b);

					return $c;
				}

				$cookieValue = f1($authenticator1, $authenticator2);
				setcookie("rememberme", $cookieValue, time()+ 1296000);

	// 			Run query to store them in remember me table

				function f2($a){

					$b = hash("sha256", $a);
					return $b;
				}

				$f2authenticator2 = f2($authenticator2);

				$user_id = $_SESSION['user_id'];

				$expiration = date("Y-m-d H:i:s", time()+ 1296000);

				$sql = "INSERT INTO rememberme (authenticator1, f2authenticator2, user_id, expires) VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";

				$result = mysqli_query($link, $sql);

	// 				if query unsuccessful
	// 					print "error"

				if (!$result) {

					echo "<div class='alert alert-danger'>There was an error storing data to remember you next time.</div>";

	// 				else
	// 					print "success"

				} else {
					echo "success";
				}			
			}
		}
	}
?>