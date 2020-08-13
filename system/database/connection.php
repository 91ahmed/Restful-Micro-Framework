<?php

	namespace System\Database;
	
	/**
	 *	Singleton DB class
	 *	Using PDO for create a database connection
	 */
	class Connection
	{	
		/**
		 *	@var $driver, default database driver
		 *
		 *  [ 
		 *		mysql  - default port 3306
		 *		pgsql  - default port 5432
		 *		sqlsrv - default port 1433
		 *		sqlite 
		 *	]
		 */
		private $driver = DB_DRIVER;

		/**
		 *	@var $config, database configuration
		 */
		private $config = [
			'host'     => DB_HOST,
			'database' => DB_NAME,
			'user' 	   => DB_USER,
			'password' => DB_PASSWORD,
			'port' 	   => DB_PORT,
			'charset'  => DB_CHARSET,
		];

		/**
		 *	@var $sqlite, store sqlite database path
		 */
		private $sqlite = [
			'path' => ROOT.'storage/sqlite/restful.db',
		];

		/**
		 *	@var object $connect, Holds the PDO connection object
		 */
		private $connect = null;
		
		/**
		 *	@var array $options, PDO mysql configuration options
		 */
		private $options = [
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
		];

		/**
		 *	@throws PDOException
		 *	@throws Exception
		 */
		public function PDO () 
		{

			try {

				if ($this->driver === 'mysql') {
					$this->connectMySQl();
				} elseif ($this->driver === 'pgsql') {
					$this->connectPostgreSQl();
				} elseif ($this->driver === 'sqlsrv') {	
					$this->connectSQlServer();
				} elseif ($this->driver === 'sqlite') {
					$this->connectSQlite();
				}

			} catch(\PDOException $e) {
				
				exit($e->getMessage());
			}

			// Set PDO attributes
			$this->setAttributes();

			return $this->connect;
		}

		/** 
		 *	Set common PDO attributes
		 */
		private function setAttributes ()
		{
			$this->connect->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
			$this->connect->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->connect->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
			$this->connect->setAttribute(\PDO::ATTR_CASE, \PDO::CASE_NATURAL);
		}

		/**
		 *	Connect PDO to MySQl database
		 *	@return void
		 */
		private function connectMySQl ()
		{
			$this->connect = new \PDO("mysql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']};charset={$this->config['charset']}", $this->config['user'], $this->config['password'], $this->options);
		}

		/**
		 *	Connect PDO to PostgreSQl database
		 *	@return void
		 */
		private function connectPostgreSQl ()
		{
			$this->connect = new \PDO("pgsql:host={$this->config['host']};port={$this->config['port']};dbname={$this->config['database']}", $this->config['user'], $this->config['password']);
		}

		/**
		 *	Connect PDO to SQl Server database
		 *	@return void
		 */
		private function connectSQlServer ()
		{
			$this->connect = new \PDO("sqlsrv:Server=".$this->config['host'].";Database=".$this->config['database']."", $this->config['user'], $this->config['password']);
		}

		/**
		 *	Connect PDO to SQlite embedded database
		 *	@return void
		 */
		private function connectSQlite ()
		{
			$this->connect = new \PDO("sqlite:".$this->sqlite['path']);
		}
	}

?>