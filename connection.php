<?php

$link = mysqli_connect("localhost", "mynotes", "K8CC9V9o7JMETV9o", "onlinenotes");

if (mysqli_connect_error()) {
 	
 	die("Error : Unable to connect : ". mysqli_connect_error());
} 

//echo "<b>Connected Successfully....</b>";

?>