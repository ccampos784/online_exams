<?php
	include "prof_header.php";
			
	//format data for curl
	foreach($data as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
			
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/view_all_grades.php");
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
	
	//sort as necessary
	$filter_flag = 0;
	if( isset($_POST['sortby']) ) {
		if ($_POST['sortby'] === "released") {
			$filter_flag = 1;
		}
		if ($_POST['sortby'] === "not_released") {
			$filter_flag = 2;
		}
	}
		
	foreach ($grades as $grade) {
		//get the exam info for each test
		//open connection
		if ($filter_flag == 1 && $grade['release'] == 0) {
			continue;
		} elseif ($filter_flag == 2 && $grade['release'] == 1) {
			continue;
		}
		
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
            'gradeID' => $grade['gradeID']
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

		if ($grade['release'] === '1') {
			$released = "Yes";
		} else {
			$released = "No";
		}
		//$released = $grade['release'];
		$table_info .= "<tr><td>" . $test_info["testname"] . "</td><td>" . $grade['ucid'] . "</td><td>" . $student_points . "/" . $total_points . "</td><td>". $grade["date"] . "</td><td>" . $released . "</td><td><button onclick=\"showgradeinfo(" . $grade["gradeID"] . ")\">View Info</button></td>";	
	}
?>
<p>Shown below are grades for exams that students have taken.</p>
<div><table>
	<tr>
		<th>Test</th>
		<th>Student</th>
		<th>Grade</th>
		<th>Date</th>
		<th>Released</th>
		<th>View Info</th>
	</tr>
	<?php echo $table_info; ?>
</table>
</div>
