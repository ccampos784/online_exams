<?php
	//header file for student files
	session_start();
	//if we are not logged in don't allow access
	if (!isset($_SESSION["ucid"])) {
			//don't allow direct access to page
			header("Location: http://web.njit.edu/~chc25/access_error.html"); /* Redirect browser */
			exit();
	}
	
	if ($_SESSION["level"] === "1") {
			header("Location: http://web.njit.edu/~chc25/php/instructor.php"); /* Redirect browser */
			exit();
	}
        
	$data = $_POST;
	$data['ucid'] = $_SESSION["ucid"];
?>