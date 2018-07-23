<?php
	session_start();
	//destroy the session so we logout
	session_destroy();
	header("Location: http://web.njit.edu/~chc25/index.php?logout=true"); /* Redirect browser */
	
?>
