<?php
	
	if (!function_exists('isLive')) 
	{
		/**
		 *	Check if the script is running on local or live server.
		 *	
		 *	@return boolean
		 */
		function isLive ()
		{
			$host = array(
			    '127.0.0.1',
			    '::1'
			);

			if(!in_array($_SERVER['REMOTE_ADDR'], $host)){
			    return true;
			} else {
				return false;
			}
		}
	}

	if (!function_exists('url')) 
	{
		/**
		 *	Return the application url.
		 *	
		 *	@param string, $route
		 *	@return string
		 */
		function url ($route = null) 
		{
			// Check Http / Https
			$protocol = trim(strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5)), '/');
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== '') {
				$protocol = 'https';
			} elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'){
				$protocol = 'https';
			}

			$url  = $protocol.'://'.$_SERVER['HTTP_HOST'].'/';

			if ($route !== null || !empty($route)) {
				$url = $url.$route;
			}
			
			return $url;
		}
	}

	if (!function_exists('redirect')) 
	{
		/**
		 *	Redirect url to a specific route.
		 *
		 *	@param string, $route
		 *	@return void
		 */
		function redirect ($route = '')
		{
			$url = url();

			if (!filter_var($route, FILTER_VALIDATE_URL)) {
				if (empty($route)) {
					$url = trim($url, '/');
				} else {
					$url = $url.$route;
				}
			} else {
				$url = $route;
			}

			return header ("Location:".$url);
			exit();
		}
	}

	if (!function_exists('redirectBack')) 
	{
		/**
		 *	Redirect url back to the previous route.
		 *
		 *	@return void
		 */
		function redirectBack ()
		{
			if (isset($_SERVER['HTTP_REFERER'])) {
				return header ("Location:".$_SERVER['HTTP_REFERER']);
			} else {
				return header("location:javascript://history.go(-1)");
			}

			exit();
		}
	}

	if (!function_exists('randomChar')) 
	{
		/**
		 *	Return random characters
		 *	
		 *	@param integer $length, default 10
		 *	@return string
		 */
		function randomChar (int $length = 10) 
		{
			$char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$char = str_shuffle($char);
			$charLength = strlen($char);
			$random = null;

			for ($i = 0; $i < $length; $i++) {
				$random .= $char[rand(0, $charLength - 1)];
			}

			return $random;
		}
	}

	if (!function_exists('randomInt')) 
	{
		/**
		 *	Return random integer
		 *	
		 *	@param integer $length, default 10
		 *	@return integer
		 */
		function randomInt (int $length = 10) 
		{
			$char = '0123456789';
			$char = str_shuffle($char);
			$charLength = strlen($char);
			$random = null;

			for ($i = 0; $i < $length; $i++) {
				$random .= $char[rand(0, $charLength - 1)];
			}

			return $random;
		}
	}

	if (!function_exists('randomStr')) 
	{
		/**
		 *	Return random string
		 *	
		 *	@param integer $length, default 10
		 *	@return string
		 */
		function randomStr (int $length = 10) 
		{
			$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$char = str_shuffle($char);
			$charLength = strlen($char);
			$random = null;

			for ($i = 0; $i < $length; $i++) {
				$random .= $char[rand(0, $charLength - 1)];
			}

			return $random;
		}
	}
?>