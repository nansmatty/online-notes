<?php

session_start();
include 'connection.php';

// get the user_id of the note send through Ajax
$id = $_POST['id'];

// get the content of the note
$note = $_POST['note'];

// get the time
$time = time();

//run a query to update a note
$sql = "UPDATE notes SET note='$note', timer='$time' WHERE id='$id'";
$result = mysqli_query($link, $sql);

if (!$result) {

	echo 'error';

}



?>