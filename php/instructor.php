<?php
	include "prof_header.php";
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
  <li class="top"><a class="active" href="instructor.php">Home</a></li>
  <li class="top"><a href="question_bank.php">Question Bank</a></li>
  <li class="top"><a href="exams.php">Exams</a></li>
  <li class="top"><a href="grades.php">Grades</a></li>
  <li class="top"><a href="logout.php">Logout</a></li>
</ul>

<div class="main">
  <h2>Online Testing System</h2>
  <h3>You are currently logged in as <?php echo $_SESSION["ucid"]; ?> (instructor).</h3>
  <p>Welcome to our online testing system. As an instructor, you will be able to perform the 
following:</p>
  <ul><li>Add questions to a test bank</li>
  <li>Create exams based on questions in the bank</li>
  <li>View grades for exams</li>
  </ul>
  <p>Click the links on the menu bar to continue.</p>
</div>
</body>
</html>

