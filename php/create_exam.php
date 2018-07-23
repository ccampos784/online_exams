<?php
	include "prof_header.php";
			
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/instructor.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$json_resp = curl_exec($ch_afs);
	//echo the result
	$q_bank = json_decode($json_resp, true);
	
	//sort as necessary
	if( isset($_POST['sortby']) ) {
		if ($_POST['sortby'] === "topic") {
			usort($q_bank, function($a, $b) {
				return strcasecmp($a['topic'], $b['topic']);
			});
		}
		if ($_POST['sortby'] === "difficulty") {
			usort($q_bank, function($a, $b) {
				return $a['difficulty'] - $b['difficulty'];
			});
		}
	}
	
	//var_dump($q_bank);
	
	$q_bank_html = "";
	foreach ($q_bank as $question) {
		if ($question['difficulty'] <= 1) {
				$diff = "Easy";
		} else if ($question['difficulty'] == 2) {
				$diff = "Medium";
		} else if ($question['difficulty'] >= 3) {
				$diff = "Hard";
		}
		$answer = str_replace(array("\r\n", "\n", "\r"), '<br />', $question['answer']);
		$testcase_array = json_decode($answer);               
		$q_bank_html .= "\t\t<tr id=" . $question['questionID'] . ">";
		$q_bank_html .= "<td><input type='checkbox' name='q_checked' value='" . $question['questionID'] . "'><td>" . $question['question'] . "</td>";
		$q_bank_html .= "<td>";
		foreach ($testcase_array as $input=>$output) {
			$q_bank_html .= "Input: " . $input . "<br />";
			$q_bank_html .= "Output:<br /> " . $output . "<br />";
		}
		$q_bank_html .= "</td><td>" . $diff . "</td>";
		$q_bank_html .= "<td>" . $question['topic'] . "</td>";
		$q_bank_html .= "<td><input type=\"text\" name=\"q_points\" id='val_" . $question['questionID'] . "' onchange='totalpoints();' onkeyup='this.onchange(); onpaste='this.onchange();' oninput='this.onchange();'></td></tr>\n";
	}

 
?>
<p id="total_points">Total points: 0</p>
<p>Select the questions to use on the exam:</p>
<table>
        <tr>
        <th>Selected</th>
        <th>Question</th>
        <th>Test Cases</th>
        <th><a onclick="showCreateExams('difficulty')" href = "#">Difficulty</a></th>
        <th><a onclick="showCreateExams('topic')" href = "#">Topic</a></th>  
        <th>Points</th>
        </tr>
       <?php echo $q_bank_html; ?>
</table>

