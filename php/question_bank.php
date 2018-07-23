<?php
	include "prof_header.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Question Bank - Online Testing System</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>
</style>
<script src="../js/add_question.js"></script>
</head>
<body>
	<div>
	<ul class="top">
  		<li class="top"><a href="instructor.php">Home</a></li>
  		<li class="top"><a class="active" href="question_bank.php">Question Bank</a></li>
  		<li class="top"><a href="exams.php">Exams</a></li>
  		<li class="top"><a href="grades.php">Grades</a></li>
  		<li class="top"><a href="logout.php">Logout</a></li>
	</ul>
	</div>
	<div class="main">
		<div class="split left">
			<h2>Add Question</h2>
			<div class="qForm" id="qForm"><button onclick="showaddQForm()">Add Question</button></div><br />
		</div>
		<div class="split right">
			<div id="questions">Loading...</div>
		</div>
	</div>
</body>
</html>
