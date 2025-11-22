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

	public function getAvatar($id) {
		$this->db->query('SELECT avatar FROM users WHERE id = :id');
		$this->db->bind('id', $id);
		$this->db->execute();

		$row = $this->db->fetch();
		return $row ? $row->avatar : false;
	}

	public function register(array $data) {
		try {
			$this->db->query('INSERT INTO users (username, email, verified, password, created_at) VALUES (:username, :email, :verified, :password, :created_at)');
			$this->db->bind('username', $data['username']);
			$this->db->bind('email', $data['email']);
			$this->db->bind('verified', 0);
			$this->db->bind('password', $data['password']);
			$this->db->bind('created_at', date('Y-m-d H:i:s'));

			if ($this->db->execute())
				return $this->db->lastInsertId();
			return false;
		} catch (PDOException $e) {
			error_log("Registration error: " . $e->getMessage());
			return false;
		}
	}

	public function updateUsername($username, $id) {
		try {
			$this->db->query('UPDATE users SET username = :username WHERE id = :id');
			
			$this->db->bind('username', $username);
			$this->db->bind('id', $id);
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error updating user username: " . $e->getMessage());
			return false;
		}
	}

	public function updateEmail(array $data) {
		try {
			$this->db->query("DELETE FROM user_tokens WHERE user_id = :user_id AND type = :type");
			$this->db->bind('user_id', $data['user_id']);
			$this->db->bind('type', 'email_update');
			$this->db->execute();

			$this->db->query('UPDATE users SET email = :email WHERE id = :id');
			$this->db->bind('email', $data['email']);
			$this->db->bind('id', $data['user_id']);
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error updating user email: " . $e->getMessage());
			return false;
		}
	}

	public function updatePassword(array $data) {
		try {
			$this->db->query("DELETE FROM user_tokens WHERE user_id = :user_id AND type = :type");
			$this->db->bind('user_id', $data['user_id']);
			$this->db->bind('type', 'password_update');
			$this->db->execute();

			$this->db->query('UPDATE users SET password = :password WHERE id = :id');
			$this->db->bind('password', $data['password']);
			$this->db->bind('id', $data['user_id']);
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error updating user password: " . $e->getMessage());
			return false;
		}
	}

	public function setAvatar($avatar, $id) {
		try {
			$this->db->query('UPDATE users SET avatar = :avatar WHERE id = :id');
			$this->db->bind('avatar', $avatar);
			$this->db->bind('id', $id);
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error setting avatar: " . $e->getMessage());
		}
	}

	public function setVerified($id) {
		$this->db->query('DELETE FROM user_tokens WHERE user_id = :user_id AND type = :type');
		$this->db->bind('user_id', $id);
		$this->db->bind('type', 'email_verification');
		$this->db->execute();

		$this->db->query('UPDATE users SET verified = 1 WHERE id = :id');
		$this->db->bind('id', $id);
		$this->db->execute();
	}

	public function getVerified($id) {
		$this->db->query('SELECT verified FROM users WHERE id = :id');
		$this->db->bind('id', $id);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}
}