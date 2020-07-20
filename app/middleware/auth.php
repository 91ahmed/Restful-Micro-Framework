<?php
	
	namespace App\Middleware;
	
	class Auth
	{
		public function __construct ()
		{
			exit('auth middleware');
		}
	}
?>