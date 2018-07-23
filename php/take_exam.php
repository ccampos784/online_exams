<?php
	include "student_header.php";
			
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
	$q_bank_html = "";
	$q_bank = json_decode($test_info["test"]);
	
	foreach ($q_bank as $qID=>$points) {
		$data = array(
				'questionID' => $qID,
				//'post_to' => urlencode("instructor.php") //instructor.php returns question bank
		);
				
		//format data for curl
		foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
		rtrim($data_string, '&');
				
		//open connection
		$ch_q = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch_q,CURLOPT_URL, "https://web.njit.edu/~dkh8/onequestion_all.php");
		curl_setopt($ch_q,CURLOPT_POST, count($data));
		curl_setopt($ch_q,CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch_q, CURLOPT_RETURNTRANSFER, true);
		
		//execute post
		$json_resp = curl_exec($ch_q);
		//echo the result
		$question = json_decode($json_resp, true)[0];
		
		$answer = str_replace(array("\r\n", "\n", "\r"), '<br />', $question['answer']);
		$testcase_array = json_decode($answer);
		$q_bank_html .= "<p><b>" . $points . " POINTS:</b> " . $question['question'] . "</p>";
		$q_bank_html .= "<textarea name=\"s_answer\" id=\"" . $question['questionID'] . "\" rows=20 cols=100></textarea>\n";
	}
 
?>
<p>The following test consists of open-ended questions. Please write Python code only! Click "Submit" when you are done. Our server will test your code and grade based on the output of the code.</p>
<h3>Exam Questions:</h3>
<?php echo $q_bank_html; ?>
<br /><br />
<div id="b_container"><button onclick="gradeExam(<?php echo $_POST['testID'] . ", '" . $_SESSION['ucid'] . "'"; ?>)">Submit</button></div>
