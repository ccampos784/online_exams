<?php
	// Relay PHP script: index.html
	// Created by Christopher Campos: for CS 490 Group 2 project
	// This script relays the POST data received from the browser to the controller
	// This is a generic relay, specify the name of the php file to post to in a post variable 'post_to'

	//format data for curl
	foreach($_POST as $key=>$value) {
		if ($key === "post_to") {
			$post_to = $value;
		} else {
			$data_string .= $key.'='.urlencode($value).'&';
		} 
	}
	rtrim($data_string, '&');

	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/" . $post_to);
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result_afs = curl_exec($ch_afs);
	//echo the result

	//close connection
	curl_close($ch_afs);

	//echo the json response
	echo $result_afs;
?>

