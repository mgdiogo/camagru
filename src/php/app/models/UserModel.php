<?php 

require_once __DIR__ . "/../core/database.php";

class UserModel {
	private $db;

	public function __construct() {
		$this->db = new Database();
	}
}