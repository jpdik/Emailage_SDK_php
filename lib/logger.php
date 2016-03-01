<?php
	namespace Emailage;
	
	class logger
	{
		
		static function logit($message, $log_level = 3)
		{
			if(is_object($message) || is_array($message))
			{
				self::logObject($message);
			}
			else
			{
				if($GLOBALS['emailage_log_level'] <= $log_level)
				{
					error_log($message);
				}
			}
		}
		
		private static function logObject($object)
		{
			$object = print_r($object, true);
			$object = explode("\n", $object);
				
			foreach($object AS $line)
			{
				self::logit($line);
			}
		}
	}
	
?>