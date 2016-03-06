<?php

	class Emailage
	{
		private $allowed_formats = Array('json', 'xml');
		private $allowed_signature_methods = Array('sha1', 'sha256', 'sha384', 'sha512');
		private $URL_prefix = 'https://';
		private $URL_sandbox = 'sandbox';
		private $URL_live = 'api';
		private $URL_apex = 'emailage.com/';
		private $URL_method_base = 'EmailAgeValidator/';
		private $URL_method_flag = 'flag/';
		
		private $setting_format = 'json';
		private $setting_signature_method = 'sha1';
		private $setting_sandbox = TRUE;
		private $setting_flag = FALSE;
		private $setting_account_sid;
		private $setting_auth_token;
		private $setting_validate_response = TRUE;
		private $setting_return_parsed_result = TRUE;

		private $request_type = 'GET';
		
		public function __construct($account_sid, $auth_token, $sandbox = TRUE, $format = 'json', $signature_method = 'sha1', $validate_response = TRUE, $return_parsed_result = TRUE)
		{
			$this->changeSetting('account_sid', $account_sid);
			$this->changeSetting('auth_token', $auth_token);
			$this->changeSetting('sandbox', $sandbox);
			$this->changeSetting('format', $format);
			$this->changeSetting('signature_method', $signature_method);
			$this->changeSetting('validate_response', $validate_response);
			$this->changeSetting('return_parsed_result', $return_parsed_result);
		}
		
		public function flagFraud($email, $fraudID)
		{
			return $this->executeQuery($email, FALSE, 'fraud', $fraudID);
		}
		
		public function flagGood($email)
		{
			return $this->executeQuery($email, FALSE, 'good');
		}
		
		public function flagNeutral($email)
		{
			return $this->executeQuery($email, FALSE, 'neutral');
		}
		
		public function validateEmail($email, $recordID = NULL)
		{
			return $this->executeQuery($email, $recordID);
		}
		
		public function validateIP($ip, $recordID = NULL)
		{
			return $this->executeQuery($ip, $recordID);
		}
		
		public function validateBoth($email, $ip, $recordID = NULL)
		{
			return $this->executeQuery($email . '+' . $ip, $recordID);
		}
		
		private function executeQuery($query, $recordID = NULL, $flag = NULL, $fraudID = NULL)
		{
			if(!is_null($flag))
			{
				$this->setting_flag = TRUE;
			}
			else
			{
				$this->setting_flag = FALSE;
			}
			$URL = $this->getURL();
			$parameters = Array();
			$parameters['format'] = $this->setting_format;
			$parameters['oauth_consumer_key'] = $this->setting_account_sid;
			$parameters['oauth_nonce'] = uniqid();
			$parameters['oauth_signature_method'] = 'HMAC-' . strtoupper($this->setting_signature_method);
			$parameters['oauth_timestamp'] = time();
			$parameters['oauth_version'] = '1.0';
			$parameters['oauth_signature'] = $this->generateSig($parameters, $URL);
			$parameters['query'] = $query;
			$parameters['urid'] = $recordID;
			$parameters['flag'] = $flag;
			$parameters['fraudcodeID'] = $fraudID;
			
			$results = $this->execute($URL, $parameters);
			
			if($this->setting_validate_response)
			{
				$this->validateResponse($results);
			}
			
			if($this->setting_return_parsed_result)
			{
				return $this->returnParsedResults($results);
			}
			else
			{
				return $results;
			}
		}
		
		private function validateResponse($response)
		{
			$errorNum = NULL;
			$errorMessage = NULL;
			
			$parsed_results = $this->returnParsedResults($response);
			
			if($parsed_results->responseStatus->status == 'failed')
			{
				$errorNum = (int)$parsed_results->responseStatus->errorCode;
				$errorMessage = (string)$parsed_results->responseStatus->description;
				$this->handleError($errorNum, $errorMessage);
			}
		}
		
		private function returnParsedResults($response)
		{
			if(strtolower($this->setting_format) == 'json')
			{
				$parsed_results = $this->parseJSON($response);
			}
			else
			{
				$parsed_results = $this->parseXML($response);
			}
			return $parsed_results;
		}
		
		private function parseXML($response)
		{
			return simplexml_load_string($response);
		}
		
		private function parseJSON($response)
		{
			$json_result = json_decode($response);
			$error = json_last_error();
				
			if($error != JSON_ERROR_NONE)
			{
				switch ($error) {
					case JSON_ERROR_DEPTH:
						$errorNum = 8200;
						$errorMessage = 'JSON Error Occured. - Maximum stack depth exceeded';
						break;
					case JSON_ERROR_STATE_MISMATCH:
						$errorNum = 8201;
						$errorMessage = 'JSON Error Occured. - Underflow or the modes mismatch';
						break;
					case JSON_ERROR_CTRL_CHAR:
						$errorNum = 8202;
						$errorMessage = 'JSON Error Occured. - Unexpected control character found';
						break;
					case JSON_ERROR_SYNTAX:
						$errorNum = 8203;
						$errorMessage = 'JSON Error Occured. - Syntax error, malformed JSON';
						break;
					case JSON_ERROR_UTF8:
						$errorNum = 8204;
						$errorMessage = 'JSON Error Occured. - Malformed UTF-8 characters, possibly incorrectly encoded';
						break;
					default:
						$errorNum = 8205;
						$errorMessage = 'JSON Error Occured. - Unknown error';
						break;
				}
				$this->handleError($errorNum, $errorMessage);
			}
			return $json_result;
		}
		
		private function execute($URL, $parameters)
		{
			$URL .= '?' . http_build_query($parameters);
					
			$CH = curl_init($URL);
				
			curl_setopt($CH, CURLOPT_RETURNTRANSFER, 1); //Return data instead printing directly in Browser

			$results = curl_exec($CH);
			
			if($errno = curl_errno($CH)) {
				$error_message = curl_strerror($errno);
				$this->handleError($errno, $error_message);
			}
			
			return str_replace("\xEF\xBB\xBF", '', $results); //String Replace is clearing up some characters being sent from Emailage that json_decode doesn't like.
		}
		
		private function generateSig($parameters, $URL)
		{
			$hash_Params = Array();
			$hash_Params[] = strtoupper($this->request_type);
			$hash_Params[] = urlencode($URL);
			$hash_Params[] = urlencode(http_build_query($parameters));
			
			return base64_encode(hash_hmac(strtolower($this->setting_signature_method), join('&', $hash_Params), $this->setting_auth_token . '&', TRUE));
		}
		
		public function changeSetting($name, $value)
		{
			switch(strtolower($name))
			{
				case 'account_sid':
				case 'auth_token':
					// No Validation Needed ...
				break;
				
				case 'format':
					if(!in_array($value, $this->allowed_formats))
					{
						$this->handleError('8000', "Unable to Change Format.  Format is invalid. ($value)");
					}
				break;
				
				case 'return_parsed_result':
					if(!is_bool($value))
					{
						$this->handleError('8005', "Unable to Return Parsed Results.  Value was not True or False");
					}
				break;
				
				case 'sandbox':
					if(!is_bool($value))
					{
						$this->handleError('8001', "Unable to Change Sandbox.  Value was not True or False");
					}
				break;
				
				case 'signature_method':
					if(!in_array(strtolower($value), $this->allowed_signature_methods))
					{
						$this->handleError('8003', "Unable to Change Signature Method.  Signature Method is invalid. ($value)");
					}
				break;
				
				case 'validate_response':
					if(!is_bool($value))
					{
						$this->handleError('8004', "Unable to Change Validate Response.  Value was not True or False");
					}
				break;
				
				default:
					$this->handleError('8100', "Unable to change ($name).  Unknown Setting. ($value)");
				break;
			}
			
			$this->saveSetting($name, $value);
		}
		
		private function handleError($errorNum, $errorMessage)
		{
			print_r($errorMessage);
			throw new Exception($errorMessage, $errorNum);
		}
		
		private function saveSetting($name, $value)
		{
			$settingName = 'setting_' . $name;
			$this->$settingName = $value;
		}
		
		private function getURL()
		{
			$URL = $this->URL_prefix;
			if($this->setting_sandbox)
			{
				$URL .= $this->URL_sandbox;
			}
			else
			{
				$URL .= $this->URL_live;
			}
			
			$URL .= '.' . $this->URL_apex . $this->URL_method_base;
			
			if($this->setting_flag)
			{
				$URL .= $this->URL_method_flag;
			}
			
			return $URL;
		}
	}

?>