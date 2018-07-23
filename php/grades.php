<?php
	include "prof_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Grades - Online Testing System</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>

</style>
<script src="../js/prof_grades.js"></script>
</head>
<body onload="showallGrades();">

<ul class="top">
  <li class="top"><a href="instructor.php">Home</a></li>
  <li class="top"><a href="question_bank.php">Question Bank</a></li>
  <li class="top"><a href="exams.php">Exams</a></li>
  <li class="top"><a class="active" href="grades.php">Grades</a></li>
  <li class="top"><a href="logout.php">Logout</a></li>
</ul>

<div class="main">
  <h2>Grades</h2>
  	<div>
	Filter results:
	<select id="g_filter">
		 <option value="all">All grades</option>
		 <option value="released">Released grades</option>
		 <option value="not_released">Not Released grades</option>
	</select>
	<button onclick="sortGrades();">Filter</button>
	</div>
  <div id="grades"><p>Loading...</p></div>
</div>
</body>
</html>

