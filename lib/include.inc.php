<?php
	namespace Emailage;

	function emailage_autoloader($class)
	{
		echo $class;
	}
	
	spl_autoload_register('emailage_autoloader');
	
	/**
	 * Setting up our Default Configuration Variables
	 * 
	 */
		$default_config = Array();
		$default_config['format'] = 'json';
		$default_config['sandbox'] = TRUE;
		$default_config['log_level'] = 1; // Only the most important messages get logged.
		$default_config['throw_errors'] = TRUE; // Check the response from Emailage and throw an error on failure. Setting this to False will leave you to check responses on your own.
		
		
		config::multiple($default_config);

?>