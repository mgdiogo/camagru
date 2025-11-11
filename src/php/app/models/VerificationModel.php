<?php

require_once __DIR__ . '/../core/Model.php';

class VerificationModel extends Model {

	public function __construct() {
		$this->db = new Database();
	}

	public function generateVerificationToken($id) {
		$verificationToken = bin2hex(random_bytes(32));

		$this->db->query('UPDATE users SET verification_token = :verification_token, verification_sent = :verification_sent WHERE id = :id');
		$this->db->bind('verification_token', $verificationToken);
		$this->db->bind('verification_sent', date('Y-m-d H:i:s'));
		$this->db->bind('id', $id);
		$this->db->execute();

		return $verificationToken;
	}

	public function setVerified($id) {
		$this->db->query('UPDATE users SET verified = 1, verification_token = NULL WHERE id = :id');
		$this->db->bind('id', $id);
		$this->db->execute();
	}

	public function getVerified($id) {
		$this->db->query('SELECT verified, verification_sent FROM users WHERE id = :id');
		$this->db->bind('id', $id);

		$row = $this->db->fetch();

		if ($this->db->rowCount() > 0) {
			return $row;
		} else 
			return false;
	}
}