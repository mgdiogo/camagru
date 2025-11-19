<?php

require_once __DIR__ . '/Config.php';

class Database {
	private $host;
	private $dbname;
	private $user;
	private $pass;
	public $pdo;
	private $stmt;
	private $error;

	public function __construct() {
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

	public function query($sql): void {
		$this->stmt = $this->pdo->prepare($sql);
	}

	public function bind($param, $value, $type = null): void {
		if (is_null($type)) {
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value);
					$type = PDO::PARAM_BOOL;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				default:
					$type = PDO::PARAM_STR;
			}
		}
		$this->stmt->bindValue($param, $value, $type);
	}

	public function execute() {
		return $this->stmt->execute();
	}

	public function fetchMany() {
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function fetch() {
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_OBJ);
	}

	public function rowCount() {
		return $this->stmt->rowCount();
	}

	public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}