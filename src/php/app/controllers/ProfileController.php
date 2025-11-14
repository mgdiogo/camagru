<?php

require_once __DIR__ . '/../core/Controller.php';

class ProfileController extends Controller {
	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel();
	}
	
	public function profile() {
		$user = $this->userModel->getUserById($_SESSION['user_id']);

		if (empty($user)) {
			http_response_code(403);
			header('Location: /login');
			return;
		}

		$this->render('/pages/profile', ['title' => 'Camagru', 'username' => $user->username, 'email' => $user->email]);
	}
}