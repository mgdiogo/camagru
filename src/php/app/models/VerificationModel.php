<?php

require_once __DIR__ . '/../core/Model.php';

class VerificationModel extends Model {

	public function __construct() {
		$this->db = new Database();
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