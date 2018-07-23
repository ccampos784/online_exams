<?php
	include "prof_header.php";
			
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/view_gradebyID.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$json_resp = curl_exec($ch_afs);
	//echo the result
	$grade = json_decode($json_resp, true)[0];
	//echo $json_resp;

	//get info on questions to populate table
	$ch_q = curl_init();
	curl_setopt($ch_q,CURLOPT_URL, "https://web.njit.edu/~dkh8/instructor.php");
	curl_setopt($ch_q, CURLOPT_RETURNTRANSFER, true);
	$json_resp_q = curl_exec($ch_q);
	$q_bank = json_decode($json_resp_q, true);

	$table_info = "";	
	//get the exam info for each test
	//open connection
	
	$data = array(
			'testID' => urlencode($grade["testID"])
	);
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
	$ch_test = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_test,CURLOPT_URL, "https://web.njit.edu/~dkh8/select_test2.php");
	curl_setopt($ch_test,CURLOPT_POST, count($data));
	curl_setopt($ch_test,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_test, CURLOPT_RETURNTRANSFER, true);
	//execute post
	$json_test = curl_exec($ch_test);
	$test_info = json_decode($json_test, true)[0];

	//get comments and grades per gradeid
	$data = array(
			'questionID' => $qID,
			'gradeID' => $_POST['gradeID']
	);
	
	//set the url, number of POST vars, POST data
	curl_setopt($ch_q,CURLOPT_URL, "https://web.njit.edu/~dkh8/questionID_bygradeID.php");
	curl_setopt($ch_q,CURLOPT_POST, count($data));
	curl_setopt($ch_q,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_q, CURLOPT_RETURNTRANSFER, true);
	//execute post
	$json_test = curl_exec($ch_q);
	$question_crs_arr = json_decode($json_test, true);
	//var_dump($question_crs_arr);
	
	$points_arr = json_decode($test_info['test'], true);
	foreach ($question_crs_arr as $item) {
		$student_points += $item['grade'];
	}
	foreach ($points_arr as $point) {
        $total_points += $point;
    }

	$table_info .= "<p>Test Name: " . $test_info["testname"] . "</p>";
	$table_info .= "<p>Student UCID: " . $grade["ucid"] . "</p>";
	$table_info .= "<p>Grade Received: " . $student_points . "/" . $total_points . "</p>";
	$table_info .= "<p>Date Taken: " . $grade["date"] . "</p><p><button onclick=\"showallGrades()\">Return to Grades</button></p>";
	//$table_info .= "<p>Comments:</p> <textarea id=\"comment\" rows=10 cols=100>" . $grade["comment"] . "</textarea>";	

	//get the answers that students wrote
	$answer_array = json_decode($grade["answer"]);
	$comment_array = json_decode($grade["comment"], true);
	$count_q = 0;
	foreach ($answer_array as $qID=>$s_answer) {
		foreach($question_crs_arr as $item) {
			if ($item['questionID_fk'] === $qID) {
				$question_crs = $item;
			}
		}
		$count_q++;
		//find question
		$data = array(
			'questionID' => $qID
		);
		foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
		rtrim($data_string, '&');
		$ch_q = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch_q,CURLOPT_URL, "https://web.njit.edu/~dkh8/onequestion_all.php");
		curl_setopt($ch_q,CURLOPT_POST, count($data));
		curl_setopt($ch_q,CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch_q, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$json_test = curl_exec($ch_q);
		$q_info = json_decode($json_test, true)[0];
		
		
		$table_info .= "<h3>Question " . $count_q . ":</h3>";
		$table_info .= "<p>" . $q_info['question'] . "</p><p>Points: <input name='s_grades' id='". $q_info['questionID'] . "' type='number' value='" . $question_crs['grade']. "'>" . "/" . $points_arr[$qID] . "</p>";			
		$table_info .= "<p>Student wrote:</p><textarea disabled rows='10' cols='100'>" . $s_answer ."</textarea>";
		$table_info .= "<p>Code output:</p><textarea disabled rows='10' cols='100'>" . $question_crs['output'] ."</textarea>"; 
		$table_info .= "<p>Comments for question " . $count_q . ":</p> <textarea name=\"comments\" id=\"" . $qID . "\" rows=5 cols=100>" . $question_crs['comment'] . "</textarea>";
	}
	$table_info .= "<div><button onclick=\"updateAll(" . $_POST["gradeID"] . ");\">Update Comments/Grades</button>";
	if ($grade['release'] === '0') {
                $table_info .= "&nbsp;<button onclick=\"releaseGrade('" . $grade['gradeID'] . "', '1')\">Release Grade</button>";
        }
	$table_info .= "</div>";
?>
<h3>Grade Information</h3>
<div id="answers"><?php echo $table_info; ?></div>

