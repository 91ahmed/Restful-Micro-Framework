<?php
	/**
	 *	Database configurations
	 *	
	 *	@var DB_DRIVER    [ mysql - pgsql - sqlsrv - sqlite ]
	 *  @var DB_HOST      [ 127.0.0.1 - localhost - https://www.example.com ]
	 *	@var DB_NAME      [ database name ]
	 *	@var DB_USER	  [ database server username ]
	 *	@var DB_PASSWORD  [ database server password ] 
	 *	@var DB_PORT	  [ mysql(3306) - pgsql(5432) - sqlsrv(1433) ]
	 */
	define ('DB_DRIVER',   'mysql');
	define ('DB_HOST',     '127.0.0.1');
	define ('DB_NAME',     'restapi');
	define ('DB_USER', 	   'root');
	define ('DB_PASSWORD', '');
	define ('DB_PORT', 	   3306);
	define ('DB_CHARSET',  'utf8');
?>