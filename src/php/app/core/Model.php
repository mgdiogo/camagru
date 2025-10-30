<?php

require_once __DIR__ . '/database.php';

class Model {
	protected $db;

	public function __construct() {
		$database = new Database();
		$this->db = $database->pdo;
	}
}