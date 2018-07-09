<?php

	function errorHandler($errno, $errstr, $errfile, $errline, $errcontext){
		echo "";
	}
	set_error_handler("errorHandler");
	
	if (isset($_SESSION['user_id']) && $_GET['logout']==1) {

		session_destroy();

		setcookie("rememberme", "", time()-3600);

	}



?>