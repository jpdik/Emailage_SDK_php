<?php
	include 'Emailage.class.php';
	$account_sid = 'My Account SID';
	$authToken = 'My Auth Token';
	$testEmail = 'example@example.com';
	
	$Emailage = new Emailage($account_sid, $authToken);
	$Emailage->changeSetting('format', 'json');
	$Emailage->changeSetting('return_parsed_result', TRUE);

	$results = $Emailage->flagGood($testEmail);
		print_r($results);
	
?>