<?php 

	$password = 'Strange@#123';

	echo "<br/><br/>".$password;

	$pp = hash("sha256", $password);

	echo "<br/><br/>".$pp;

	echo "<br/><br/>".strlen($pp);

?>