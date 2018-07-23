<?php
	include "prof_header.php";
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/all_test.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$json_resp = curl_exec($ch_afs);
	//echo the result
	$tests = json_decode($json_resp, true);
	//echo $json_resp;
	
	foreach ($tests as $test) {
		//get the exam info for each test
		//open connection
		
		$data = array(
				'testID' => urlencode($test)
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
		//echo the result
		$test_info = json_decode($json_test, true)[0];
		$table_info .= "<tr><td>" . $test_info["testname"] . "</td>";
		$table_info .= "<td>" . $test_info["topic"] . "</td>";
		$table_info .= "<td><button onclick=\"showExamInfo(". $test . ");\">Details</button></td></tr>";	
	}
?>
<p>Below, you will see a list of exams that have been created. Click the "Details" button for more information about an exam.</p>
<table>
	<tr>
		<th>Exam Name</th>
		<th>Topic</th>
		<th>View Details</th>
	</tr>
	<?php echo $table_info; ?>
</table>
