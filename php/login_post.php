<?php
	// Relay PHP script: index.html
	// Created by Christopher Campos: for CS 490 Group 2 project 
	// This script relays the POST data received from the browser to the controller
	
	//format data for curl
	foreach($_POST as $key=>$value) { $data_string .= $key.'='.$value.'&'; }
	rtrim($data_string, '&');
	
	//open connection
	$ch_afs = curl_init();

	//set the url, number of POST vars, POST data
	curl_setopt($ch_afs,CURLOPT_URL, "https://web.njit.edu/~dkh8/control.php");
	curl_setopt($ch_afs,CURLOPT_POST, count($data));
	curl_setopt($ch_afs,CURLOPT_POSTFIELDS, $data_string);
	curl_setopt($ch_afs, CURLOPT_RETURNTRANSFER, true);

	//execute post
	$result_afs = curl_exec($ch_afs);
	//echo the result

	//close connection
	curl_close($ch_afs);
	
	//if the login is valid create a php session for the user
	$result_array = json_decode($result_afs, true);
	if ($result_array["status"] === "true") {
		session_start();
		$_SESSION['ucid'] = $_POST["ucid"];
		$_SESSION['level'] = $result_array["idtype"];
	}

	//echo the json response
	echo $result_afs;
?>
