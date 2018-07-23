<?php
	include "student_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Exams - Online Testing System</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>
</style>
<script src="../js/student_exam.js"></script>
</head>
<body onload="getTests();">

<ul class="top">
  <li class="top"><a href="student.php">Home</a></li>
  <li class="top"><a class="active" href="student_exams.php">Exams</a></li>
  <li class="top"><a href="student_grades.php">Grades</a></li>
  <li class="top"><a href="logout.php">Logout</a></li>
</ul>

<div class="main">
  <h2 id="test_title">Student Exams</h2>
  <div id="test_area">Loading...</div>
</div>

</body>
</html>

