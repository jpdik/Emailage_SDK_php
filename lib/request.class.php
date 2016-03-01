<?php
	namespace Emailage;

	class request
	{
		static private $live_url = 'https://api.emailage.com/';
		static private $sandbox_url = 'https://sandbox.emailage.com/';
		
		static private $valid_format_respones = Array('json', 'xml');
		
		static function Execute(array $parameters)
		{
			if(!isset($parameters['format']) || !in_array($parameters['format'], self::$valid_format_respones))
			{
				$parameters['format'] = config::get('format');
			}
			
			$parameters['oauth_nonce'] = uniqid('emailage_');
			$parameters['oauth_consumer_key'] = config::get('account_SID');
			$parameters['oauth_timestamp'] = time();
			$parameters['oauth_signature_method'] = 'HMAC-SHA1';
			$parameters['oauth_version'] = '1.0';
		}
		
		static private function curl($parameters)
		{
			$query = http_build_query($parameters);
			
			$query .= '&oauth_signature=' . base64_encode(hash_hmac('sha1', config::get('auth_token')) . '&' . $query);
			
			$CH = curl_init(self::$sandbox_url . '?' . $query);
			return curl_exec($CH);
		}
	}

?>