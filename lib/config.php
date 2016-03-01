<?php
	namespace Emailage;
	
	class config
	{
		static function single($name, $value)
		{
			$GLOBALS['emailage_' . strtolower($name)] = $value;
		}
		
		static function multiple(array $configs)
		{
			foreach($configs AS $name => $value)
			{
				self::single($name, $value);
			}
		}
		
		static function test($test_vars = true)
		{
			// Needs to test PHP And variables;
		}
		
		static function get($name)
		{
			return $GLOBALS['emailage_' . $name];
		}
	}