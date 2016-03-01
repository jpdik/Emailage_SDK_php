<?php
	namespace Emailage;

	class request
	{
		static private $live_url = 'https://api.emailage.com/emailagevalidator/';
		static private $sandbox_url = 'https://sandbox.emailage.com/emailagevalidator/';
		static private $flag_url_addition = 'flag/';
		
		static private $valid_format_respones = Array('json', 'xml');
		
		static function Execute(array $parameters, $flag = false)
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
			
			return self::curl($parameters);
		}
		
		static private function curl($parameters)
		{
			$query = http_build_query($parameters);
			
			$query .= '&oauth_signature=' . base64_encode(hash_hmac('sha1', config::get('auth_token')) . '&' . $query);
			
			$CH = curl_init(self::URL() . '?' . $query);
			return curl_exec($CH);
		}
		
		static function URL()
		{
			if(config::get('sandbox'))
			{
				$URL = self::$sandbox_url;
			}
			else
			{
				$URL = self::$live_url;
			}
				
			if($flag)
			{
				$URL .= self::$flag_url_addition;
			}
			return $URL;
		}
	}

?>