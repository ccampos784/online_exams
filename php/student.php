<?php
	include "student_header.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Home - Online Testing System</title>
<link rel="stylesheet" type="text/css" href="../css/main.css">
<style>
</style>
</head>
<body>

<ul class="top">
  <li class="top"><a class="active" href="student.php">Home</a></li>
  <li class="top"><a href="student_exams.php">Exams</a></li>
  <li class="top"><a href="student_grades.php">Grades</a></li>
  <li class="top"><a href="logout.php">Logout</a></li>
</ul>

<div class="main">
  <h2>Online Testing System</h2>
  <h3>You are currently logged in as <?php echo $_SESSION["ucid"]; ?> (student).</h3>
  <p>Welcome to our online testing system. As a student, you will be able to perform the 
following:</p>
  <ul><li>Take an exam</li>
  <li>View grade results for exams taken</li>
  </ul>
  <p>Click the links on the sidebar to continue.</p>
</div>

</body>
</html>

