<?php
	include '../lib/include.inc.php'; // Loading Emailage
	
	$config = Array();
	$config['account_SID'] = '';
	$config['auth_token'] = '';
	
	\Emailage\config::multiple($config);
	
	// Simple Call
	$results = \Emailage\validate::email('example@example.com');
	
	// Supply A record ID from your system for the Email
	$results = \Emailage\validate::email('example@example.com', 145277);
	
	// Change the response format just for this call
	$results = \Emailage\validate::email('example@example.com', NULL, 'json');
?>