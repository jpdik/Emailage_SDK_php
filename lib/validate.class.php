<?php
	namespace Emailage;

	class validate
	{
		static function email($email, $format = 'json')
		{
			return self::executeRequest(['query' => $email, 'format' => 'json']);
		}
		
		static function IP($IP, $format = 'json')
		{
			return self::executeRequest(['query' => $IP, 'format' => 'json']);
		}
		
		static function emailAndIP($email, $IP, $format = 'json')
		{
			return self::executeRequest(['query' => $email . '+' . $IP, 'format' => 'json']);
		}
		
		private static function executeRequest($parameters)
		{
			return request::Execute($parameters);
		}
	}

?>