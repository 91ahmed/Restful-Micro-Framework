<?php
	
	namespace System\Database;

	/**
	 * PDO database connection
	 *
	 *	@author Ahmed Hassan
	 */
	class Connect
	{
		
		/**
		 *	@var string $driver 
		 *	(mysql - sqlsrv - pgsql - sqlite)
		 */
		private $driver   = DB_DRIVER;

		/**
		 *	@var string $host 
		 *	(localhost - 127.0.0.1 - Your host url => https://www.example.com)
		 */
		private $host     = DB_HOST;

		/**	@var string $database (database name) */
		private $database = DB_NAME;

		/** @var string $username (database username) */
		private $username = DB_USER;

		/** @var string $password (database password) */
		private $password = DB_PASSWORD;

		/**
		 *	@var integer $port 
		 *	(mysql 3306 - pgsql 5432 - sqlsrv 1433)
		 */
		private $port     = DB_PORT;

		/** @var string $charset (database charset) */
		private $charset  = DB_CHARSET;

		/**
		 *	@var object $connect
		 *	Holds the PDO connection object.
		 */
		private $connect;

		/**
		 *	@var string $sqlitePath, store the sqlite embeded file path.
		 */
		private $sqlitePath = 'storage/sqlite/restful.db';

		/**
		 *	@var array $options, PDO mysql configuration options
		 */
		private $options = [
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
		];

		/**
		 *	Open database connection
		 *
		 *	@return object, database connect
		 */
		public function open () 
		{
			try {

				if ($this->driver === 'mysql') {
					$this->mysql();
				} elseif ($this->driver === 'pgsql') {
					$this->postgresql();
				} elseif ($this->driver === 'sqlsrv') {
					$this->sqlserver();
				} elseif ($this->driver === 'sqlite') {
					$this->sqlite();
				} else {
					throw new Exception("Undefined database driver ({$this->driver})", 1);
				}

			}catch(\PDOException $e) {
				
				exit($e->getMessage());
			}

			// Set PDO attributes
			$this->setPdoAttributes();

			return $this->connect;
		}

		/**
		 *	Close database connection
		 *
		 *	@return void
		 */
		public function close () 
		{
			$this->connect = null;
		}

		/** 
		 *	Set common PDO attributes.
		 *
		 *	@return void
		 */
		private function setPdoAttributes ()
		{
			$this->connect->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->connect->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
		}

		/**
		 *	Connect pdo with mysql.
		 *
		 *	@return void
		 */
		private function mysql ()
		{
			$this->connect = new \PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}", $this->username, $this->password, $this->options);
		}

		/**
		 *	Connect pdo with postgresql.
		 *
		 *	@return void
		 */
		private function postgresql ()
		{
			$this->connect = new \PDO("pgsql:host={$this->host};port={$this->port};dbname={$this->database}", $this->username, $this->password);
		}

		/**
		 *	Connect pdo with sql server.
		 *
		 *	@return void
		 */
		private function sqlserver ()
		{
			$this->connect = new \PDO("sqlsrv:Server=".$this->host.";Database=".$this->database."", $this->username, $this->password);
		}

		/**
		 *	Connect pdo with sqlite
		 *
		 *	@return void
		 */
		private function sqlite ()
		{
			$this->connect = new \PDO("sqlite:".$this->sqlitePath);
		}

		/**
		 *	Set the database driver
		 *
		 *	@var string, $driver
		 *	@return void
		 */
		public function setDriver ($driver) 
		{
			$this->driver = $driver;
		}

		/**
		 *	Set the database host
		 *
		 *	@var string, $host
		 *	@return void
		 */
		public function setHost ($host) 
		{
			$this->host = $host;
		}

		/**
		 *	Set the database name
		 *
		 *	@var string, $database
		 *	@return void
		 */
		public function setDatabase ($database) 
		{
			$this->database = $database;
		}

		/**
		 *	Set the database username
		 *
		 *	@var string, $username
		 *	@return void
		 */
		public function setUsername ($username) 
		{
			$this->username = $username;
		}

		/**
		 *	Set the database password
		 *
		 *	@var string, $password
		 *	@return void
		 */
		public function setPassword ($password) 
		{
			$this->password = $password;
		}

		/**
		 *	Set the database port
		 *
		 *	@var integer, $port
		 *	@return void
		 */
		public function setPort ($port) 
		{
			$this->port = $port;
		}

		/**
		 *	Set the database charset
		 *
		 *	@var string, $charset
		 *	@return void
		 */
		public function setCharset ($charset) 
		{
			$this->charset = $charset;
		}

		/**
		 *	Set sqlite database file path
		 *
		 *	@var string, $path
		 *	@return void
		 */
		public function setSqlitePath ($path)
		{
			$this->sqlitePath = $path;
		}
 	}
?>

<?php

 	/**
 		=====
		USAGE
		=====
		
		// Connect database
	 	$connect = new Connect;
	 	$connect->open();

	 	// Change database configurations (OR) connect to another database
	 	$connect = new Connect;
	 	$connect->setDriver('');
	 	$connect->setHost('');
	 	$connect->setDatabase('');
	 	$connect->setUsername('');
	 	$connect->setPassword('');
	 	$connect->setPort('');
	 	$connect->setCharset('');
	 	$connect->open();

		// Change sqlite file path
		$connect = new Connect;
	 	$connect->setSqlitePath('');
	 	$connect = open();

	 	// Close database connection
	 	$connect = new Connect;
	 	$connect = close();
	*/
?>