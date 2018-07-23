<?php
	include "prof_header.php";
			
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/select_test2.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$json_resp = curl_exec($ch_afs);
	//echo the result
	$test_info = json_decode($json_resp, true)[0];
	
	$points_arr = json_decode($test_info['test'], true);
	foreach ($points_arr as $point) {
			$total_points += $point;
	}

	$table_info = "<p>Exam Name: " . $test_info['testname']. "</p>";
	$table_info .= "<p>Topic: " . $test_info['topic']. "</p>";
	$table_info .= "<p>Total points: " . $total_points . "</p>";
	$table_info .= "<h3>Questions:</h3><table><tr><th>Question</th><th>Points</th><th>Test Cases</th></tr>";
	
	//get question info and points
	$question_array = json_decode($test_info["test"]);
	foreach ($question_array as $qID=>$s_answer) {
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
		$question = json_decode($json_test, true)[0];
		
		$table_info .= "<tr><td>" . $question['question'] . "</td>";
		$table_info .= "<td>" . $points_arr[$qID] . "</td><td>";

		$answer = str_replace(array("\r\n", "\n", "\r"), '<br />', $question['answer']);
		$testcase_array = json_decode($answer);
		$case_count = 0;
		foreach ($testcase_array as $input=>$output) {
			   $case_count++;
			   $table_info .= "<b>Case " . $case_count . ":</b><br />Input: " . $input . "<br 
/>";
			   $table_info .= "Output:<br /> " . $output . "<br />";
		}
		$table_info .= "</td>";
	}
	$table_info .= "</table>";


	
?>
<h3>Exam Information</h3>
<div id="answers"><?php echo $table_info; ?></div><br />
<div><button onclick="showExams()">Return to Exams</button></div>
