<?php 

require_once __DIR__ . '/../core/Model.php';

class UserModel extends Model {
	public function __construct() {
		$this->db = new Database();
	}

	public function getUserByEmailOrUsername($email, $username) {
		$this->db->query('SELECT * FROM users WHERE username = :username OR email = :email');
		$this->db->bind('username', $username);
		$this->db->bind('email', $email);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}

	public function getUserById($id) {
		$this->db->query('SELECT * FROM users WHERE id = :id');
		$this->db->bind('id', $id);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}

	public function register(array $data) {
		try {
			$this->db->query('INSERT INTO users (username, email, verified, password, created_at) VALUES (:username, :email, :verified, :password, :created_at)');
			$this->db->bind('username', $data['username']);
			$this->db->bind('email', $data['email']);
			$this->db->bind('verified', 0);
			$this->db->bind('password', $data['password']);
			$this->db->bind('created_at', date('Y-m-d H:i:s'));
	
			return $this->db->execute();
		} catch (PDOException $e) {
			error_log("Registration error: " . $e->getMessage());
			return false;
		}
	}
}