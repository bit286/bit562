<?php

	class CheckUser {

		private $username;
		private $password;

		function __construct($username, $password) {
			$this->username = $username;
			$this->password = $password;
		}

		function authenticate () {

			require_once('DBManager.php');
			require_once('db_login.php');

		    $db_dsn = "mysql:host={$db_host};dbname={$db_database}";

			$DB = new DBManager($db_dsn, $db_username, $db_password);
			$DB->open();

			$loginQuery = "SELECT COUNT(*) FROM users WHERE userName = '" .$this->username. "' AND password = '" .$this->password. "'";
			$getLogin = $DB->execute($loginQuery);

					
			return $getLogin;
		}
}
?>
