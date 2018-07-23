<?php
	//Created by Christopher Campos
	if (isset($_GET['logout']) && ($_GET['logout'] === "true")) {
		$logout_msg = "<p align=\"center\">You have logged out successfully.</p>";
	} else {
		$logout_msg = "";
	}
?>

<!DOCTYPE html>
<!-- 
	Login page: index.html
	Created by Christopher Campos: for CS 490 Group 2 project 
--> 
<html>
<head>
	<title>Online Testing System: Login</title>
	<style>
		input {
			width: 100%;
			margin: 8px 0;
			padding: 8px 20px;
			box-sizing: border-box;
			border: 1px solid #ccc;
			border-radius: 4px;
		}
		div.container {
			margin: auto;
			width: 300px;
			border-radius: 5px;
			font-family: "Verdana", Geneva, sans-serif;
		}
		div.header {
			margin: auto;
			width: 800px;
			font-family: "Verdana", Geneva, sans-serif;
		}
		div.b_container {
			text-align: center;
		}
		div.footer {
			width: 100%;
			padding: 10px
			position: fixed;
			text-align: right;
			font-family: "Verdana", Geneva, sans-serif;
		}
		.button {
			background-color: #f44336;
			width: 200px;
			color: white;
			font-size: 16px;
			text-align: center;
			padding: 12px 20px;
			border-radius: 8px;
			border: none;
		}
	</style>
	<script src="js/login.js"></script>
</head>
<body>
	<div class="header"><h1 align="center">Online Testing System</h1></div>
	<div class="container">
		<form onsubmit="sendData(); return false">
			<h2 align="center">Login</h2><?php echo $logout_msg; ?>
			<label for="ucid">UCID:</label> 
			<input type="text" id="ucid">
			<label for="ucid">Password:</label> 
			<input type="password" id="pass">
			<div class="b_container"><input class="button" type="submit" value="Login"></div>
			<div id="resp"></div>
		</form>
	</div>
	<div class="footer"><p>Version: Final Release 06/18/2018<br />Created by Group 2</p></div>
</body>
</html>
