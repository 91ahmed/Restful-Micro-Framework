<?php
	ob_start();

	// Directory separator
	define ('DS', DIRECTORY_SEPARATOR);

	// Root path
	define ('ROOT', __DIR__ . DS);

	// Errors controll
	ini_set ('display_errors', 1);
	error_reporting (E_ALL);

	// Time zone
	ini_set ('date.timezone', 'Africa/Cairo');

	// Charset
	ini_set ('default_charset', 'UTF-8');
 
	// Memory limit
	ini_set('memory_limit', '128M');

	// URL include
	ini_set ('allow_url_include', 0);

	/**
	 *	Limits the maximum execution time, The default limit is 30 seconds
	 *  If set to zero, no time limit is imposed.
	 */
	set_time_limit(0);

	// Include important files
	require (ROOT.'config'.DS.'app.php');
	require (ROOT.'bootstrap'.DS.'autoload.php');
	require (ROOT.'vendor'.DS.'autoload.php');
	require (ROOT.'route'.DS.'api.php');
?>