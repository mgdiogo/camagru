<?php 

class TokenModel extends Model {
	public function __construct() {
		$this->db = new Database();
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

	public function generateEmailVerificationToken($id) {
		$this->db->query("DELETE FROM user_tokens WHERE user_id = :id AND type = :type");
		$this->db->bind('id', $id);
		$this->db->bind('type', 'email_verification');
		$this->db->execute();

		$verificationToken = bin2hex(random_bytes(32));

		$this->db->query('INSERT INTO user_tokens (user_id, token, type, expires_at) VALUES (:user_id, :token, :type, :expires_at)');
		$this->db->bind('user_id', $id);
		$this->db->bind('token', $verificationToken);
		$this->db->bind('type', 'email_verification');
		$this->db->bind('expires_at', date('Y-m-d H:i:s', strtotime('+5 minutes')));
		$this->db->execute();

		return $verificationToken;
	}

	public function getLatestEmailVerificationToken($id) {
		$this->db->query("
			SELECT token, expires_at
			FROM user_tokens
			WHERE user_id = :user_id 
			  AND type = 'email_verification'
			ORDER BY created_at DESC
			LIMIT 1
		");
		$this->db->bind(':user_id', $id);
		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}
}