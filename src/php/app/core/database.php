<?php

require_once __DIR__ . '/config.php';

class Database
{
	private $host;
	private $dbname;
	private $user;
	private $pass;
	public $pdo;

	function __construct() {
		$this->host = DB_HOST;
		$this->dbname = DB_NAME;
		$this->user = DB_USER;
		$this->pass = DB_PASSWORD;

		try {
			$this->pdo = new PDO(
				"mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
				$this->user,
				$this->pass
			);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		} catch (PDOException $e) {
			die("Database connection failed: " . $e->getMessage());
		}
	}
}