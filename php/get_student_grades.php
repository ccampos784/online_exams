<?php
	include "student_header.php";
			
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/view_grade.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$json_resp = curl_exec($ch_afs);
	//echo the result
	$grades = json_decode($json_resp, true);
	//echo $json_resp;
	
	$table_info = "";
	//an attempt to optimize the grade loading code and reduce the number of curl requests done
	//when we get test info save the info in the array so we can reuse it
	//initially it is empty
	$test_cache = array();
	
	foreach ($grades as $grade) {
		if ($grade['release'] === '0') {
			continue;
		}
		//get the exam info for each test
		//open connection
		
		//check if the test info is cached already
		//if not curl and add it to array cache
		if ( !array_key_exists($grade["testID"], $test_cache)) { 
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
			$test_cache[$grade["testID"]] = $test_info;
		}
		$test_info = $test_cache[$grade["testID"]];
		$points_arr = json_decode($test_info['test'], true);

		//get comments and grades per gradeid
		$data = array(
				'gradeID' => (int)$grade['gradeID']
		);
		//format data for curl
		foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
		rtrim($data_string, '&');
				
		$ch_q = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch_q,CURLOPT_URL, "https://web.njit.edu/~dkh8/questionID_bygradeID.php");
		curl_setopt($ch_q,CURLOPT_POST, count($data));
		curl_setopt($ch_q,CURLOPT_POSTFIELDS, $data_string); 
		curl_setopt($ch_q, CURLOPT_RETURNTRANSFER, true);
		//execute post
		$json_test = curl_exec($ch_q);
		$question_crs_arr = json_decode($json_test, true);
				
		$student_points = 0;
		$total_points = 0;
		foreach ($question_crs_arr as $item) {
			$student_points += $item['grade'];
		}
		foreach ($points_arr as $point) {
			$total_points += $point;
		}

		//var_dump($test_info);
		$table_info .= "<tr><td>" . $test_info["testname"] . "</td><td>" . $student_points . "/" . $total_points . "</td><td>". $grade["date"] . "</td><td><button onclick=\"showgradeinfo(" . $grade["gradeID"] . ")\">View Info</button></td>" ;		
	}
?>
<p>Shown below are grades for exams you have taken.</p>
<table>
	<tr>
		<th>Test</th>
		<th>Grade</th>
		<th>Date</th>
		<th>View Info</th>
	</tr>
	<?php echo $table_info; ?>
</table>
