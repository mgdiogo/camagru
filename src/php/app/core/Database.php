<?php

require_once __DIR__ . '/Config.php';

class Database
{
	private $host;
	private $dbname;
	private $user;
	private $pass;
	public $pdo;

	public function connect()
	{
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
			
			return $this->pdo;
		} catch (PDOException $e) {
			die("Database connection failed: " . $e->getMessage());
		}
	}
}