<?php
	include '../lib/include.inc.php'; // Loading Emailage
	
	$config = Array();
	$config['account_SID'] = '';
	$config['auth_token'] = '';
	
	\Emailage\config::multiple($config);
	
	$results = \Emailage\validate::email('jonathan.pitcher@gmail.com');
?>