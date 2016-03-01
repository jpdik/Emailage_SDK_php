<?php
	namespace Emailage;

	class validate
	{
		static function email($email, $recordID = NULL, $format = NULL)
		{
			return self::executeRequest(['query' => $email, 'urid' => $recordID, 'format' => $format]);
		}
		
		static function IP($IP, $recordID = NULL, $format = NULL)
		{
			return self::executeRequest(['query' => $IP, 'urid' => $recordID, 'format' => $format]);
		}
		
		static function emailAndIP($email, $IP, $recordID = NULL, $format = NULL)
		{
			return self::executeRequest(['query' => $email . '+' . $IP, 'urid' => $recordID, 'format' => $format]);
		}
		
		private static function executeRequest($parameters)
		{
			return request::Execute($parameters);
		}
	}

?>