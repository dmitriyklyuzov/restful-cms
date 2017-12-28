<?php 

	/**
	DB_CONNECTION=mysql
	DB_HOST=127.0.0.1
	DB_PORT=8889
	DB_DATABASE=rentit
	DB_USERNAME=root
	DB_PASSWORD=root
	*/

	class db{
		// properties
		private $dbhost = 'localhost:8889';
		private $dbuser = 'root';
		private $dbpass = 'root';
		private $dbname = 'restful-cms';

		// connect to db
		public function connect(){
			$mysql_connect_string = "mysql:host=$this->dbhost;dbname=$this->dbname";
			$dbConnection = new PDO($mysql_connect_string, $this->dbuser, $this->dbpass);
			$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $dbConnection;
		}
	}
 ?>