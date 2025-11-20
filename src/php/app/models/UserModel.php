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

	public function getEmailVerificationToken($token) {
		$this->db->query("
			SELECT 
				users.id,
				users.verified,
				user_tokens.token,
				user_tokens.expires_at
				FROM user_tokens
				JOIN users on user_tokens.user_id = users.id
				WHERE user_tokens.token = :token
					AND user_tokens.type = :type
					AND user_tokens.expires_at > NOW()
		");
		$this->db->bind('type', 'email_verification');
		$this->db->bind('token', $token);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}

	public function getEmailUpdateToken($token) {
		$this->db->query("
			SELECT 
				users.id,
				users.verified,
				user_tokens.token,
				user_tokens.expires_at
				FROM user_tokens
				JOIN users on user_tokens.user_id = users.id
				WHERE user_tokens.token = :token
					AND user_tokens.type = :type
					AND user_tokens.expires_at > NOW()
		");
		$this->db->bind('type', 'email_update');
		$this->db->bind('token', $token);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}

	public function getTempMail($token) {
		$this->db->query('SELECT user_id, temp_email FROM user_tokens WHERE token = :token AND type = :type');
		$this->db->bind('token',$token);
		$this->db->bind('type','email_update');
		$this->db->execute();

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
			error_log("Error updating user: " . $e->getMessage());
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
			error_log("Error updating user: " . $e->getMessage());
			return false;
		}
	}

	public function generateUpdateEmailToken($id) {
		$this->db->query("DELETE FROM user_tokens WHERE user_id = :id AND type = :type");
		$this->db->bind('id', $id);
		$this->db->bind('type', 'email_update');
		$this->db->execute();

		$updateToken = bin2hex(random_bytes(32));

		$this->db->query('INSERT INTO user_tokens (user_id, token, type, expires_at) VALUES (:user_id, :token, :type, :expires_at)');
		$this->db->bind('user_id', $id);
		$this->db->bind('token', $updateToken);
		$this->db->bind('type', 'email_update');
		$this->db->bind('expires_at', date('Y-m-d H:i:s', strtotime('+5 minutes')));
		$this->db->execute();

		return $updateToken;
	}

	public function setTempEmail($email, $id) {
		try {
			$this->db->query('UPDATE user_tokens SET temp_email = :temp_email WHERE user_id = :user_id AND type = :type');
			$this->db->bind('temp_email', $email);
			$this->db->bind('user_id', $id);
			$this->db->bind('type', 'email_update');
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error setting temp mail: " . $e->getMessage());
		}
	}

	public function setAvatar($avatar) {
		try {
			$this->db->query('UPDATE users SET avatar = :avatar');
			$this->db->bind('avatar', $avatar);
			$this->db->execute();
		} catch (PDOException $e) {
			error_log("Error setting avatar: " . $e->getMessage());
		}
	}
}