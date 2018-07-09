<?php

session_start();

include 'connection.php';

// get the user_id

$user_id = $_SESSION['user_id'];

//get the username through Ajax call

$username = $_POST['username'];

//Update query

$sql = "UPDATE users SET username = '$username' WHERE user_id = '$user_id'";

$result = mysqli_query($link, $sql);

if ($result) {
	
	echo "true";
	exit();

}

?>

