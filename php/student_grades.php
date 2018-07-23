<?php
	include "student_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Grades - Online Testing System</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>
</style>
<script src="../js/student_grades.js"></script>
</head>
<body onload="showallGrades();">

<ul class="top">
  <li class="top"><a href="student.php">Home</a></li>
  <li class="top"><a href="student_exams.php">Exams</a></li>
  <li class="top"><a class="active" href="student_grades.php">Grades</a></li>
  <li class="top"><a href="logout.php">Logout</a></li>
</ul>

<div class="main">
  <h2>Grades</h2>
  <div id="grades"><p>Loading grades...</p></div>
</div>

</body>
</html>

