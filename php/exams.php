<?php
	include "prof_header.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Exams - Online Testing System</title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>
</style>
<script src="../js/exams.js"></script>
</head>
<body onload="showExams();">
	<ul class="top">
  		<li class="top"><a href="instructor.php">Home</a></li>
  		<li class="top"><a href="question_bank.php">Question Bank</a></li>
  		<li class="top"><a class="active" href="exams.php">Exams</a></li>
  		<li class="top"><a href="grades.php">Grades</a></li>
  		<li class="top"><a href="logout.php">Logout</a></li>
	</ul>
	<div class="main">
		<div class="split left">
			<div class="qForm" id="qForm"><h2>Exams</h2><button onclick="showaddExamForm()">Create an Exam</button></div>
			<div class="qForm" id="examForm"></div>
		</div>
		<div class="split right">
			<div id="questions">Loading exams...</div>
		</div>
	</div>
</body>
</html>
