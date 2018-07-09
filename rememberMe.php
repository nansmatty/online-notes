<?php

	// if the user is not logged in and remember me cookie exists

	if (!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])) {		
		//array_key_exists('user_id', $_SESSION); i can use this inside the if statement instead of isset function....
		//f1 COOKIE: $a . "," . bin2hex($b)
		//f2 hash("sha256", $a)
		// 	extract $aunthentificators 1&2 from the cookie

		list($aunthentificator1, $aunthentificator2) = explode(",", $_COOKIE['rememberme']); // this array function can de-concatenate 
		$authentificator2 = hex2bin($aunthentificator2);

		$f2authentificator2 = hash("sha256", $authentificator2);

		// 	Look for aunthentificator1 in the remember me table

		$sql = "SELECT * FROM rememberme WHERE authenticator1 = '$aunthentificator1'";

		$result = mysqli_query($link, $sql);

		if (!$result) {
			echo "<div class='alert alert-danger'>There was an error running the query.</div>";
			exit();
		}
		$count = mysqli_num_rows($result);
		if ($count !== 1) {

			echo "<div class='alert alert-danger'>Remember me process fail.</div>";
			exit();

		}
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

		// 	if aunthentificator2 does not match
		// 		print error

		if (!hash_equals($row['f2authenticator2'], $f2authentificator2)) {
			
			echo "<div class='alert alert-danger'>Hash Equals returned false.</div>";
			
		} else{

			// Create two variables $authenticator1 and $authenticator2

			$authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
			$authenticator2 = openssl_random_pseudo_bytes(20);

			// Store them in a cookie

			function f1($a, $b){

				$c = $a . "," . bin2hex($b);

				return $c;
			}

			$cookieValue = f1($authenticator1, $authenticator2);
			setcookie("rememberme", $cookieValue, time()+ 1296000);

			//Run query to store them in remember me table

			function f2($a){

				$b = hash("sha256", $a);
				return $b;
			}

			$f2authenticator2 = f2($authenticator2);

			$user_id = $_SESSION['user_id'];

			$expiration = date("Y-m-d H:i:s", time()+ 1296000);

			$sql = "INSERT INTO rememberme (authenticator1, f2authenticator2, user_id, expires) VALUES ('$authenticator1', '$f2authenticator2', '$user_id', '$expiration')";

			$result = mysqli_query($link, $sql);

		// if query unsuccessful
		// 	print "error"

			if (!$result) {

				echo "<div class='alert alert-danger'>There was an error storing data to remember you next time.</div>";
			}

			$_SESSION['user_id'] = $row['user_id'];

			// Log the user in and redirect to notes page

			header("location:mainpageloggedin.php");
		}
		
	}
	
	
?>