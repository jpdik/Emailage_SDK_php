<?php
	namespace Emailage;
	
	class flag
	{
		static public function fraud($email, $fraudID, $format = NULL)
		{
			request::Execute(['flag' => 'good', 'fraudcodeID' => $fraudID, 'query' => $email], true);
		}
		
		static public function good($email, $format = NULL)
		{
			request::Execute(['flag' => 'good', 'query' => $email], true);
		}
		
		static public function neutral($email, $format = NULL)
		{
			request::Execute(['flag' => 'neutral', 'query' => $email], true);
		}
	}


?>