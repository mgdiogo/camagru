<?php

require_once __DIR__ . '/../core/Controller.php';

class ProfileController extends Controller {
	private $userModel;
	private $tokenModel;

	public function __construct() {
		$this->userModel = new UserModel;
		$this->tokenModel = new TokenModel;
	}

	public function profile() {
		$user = $this->userModel->getUserById($_SESSION['user_id']);

		if (empty($user)) {
			header('Location: /login');
			return;
		}

		$this->render('/pages/profile', ['title' => 'Camagru', 'username' => $user->username, 'email' => $user->email, 'avatar' => $user->avatar]);
	}

	public function update() {
		$token = $_GET['token'];

		$user = $this->tokenModel->getEmailUpdateToken($token);

		if (!$token || !$user) {
			$this->render('/pages/update', ['title' => 'Camagru', 'image' => '/images/404.png', 'result_title' => 'Invalid or expired link', 'message' => 'Invalid information update request.']);
			return;
		}
		$tempMail = $this->tokenModel->getTempMail($token);
		if ($tempMail)
			$this->userModel->updateEmail(['user_id' => $tempMail->user_id, 'email' => $tempMail->temp_email]);
		$this->render('/pages/update', ['title' => 'Camagru', 'image' => '/images/success.jpg', 'result_title' => 'Information changed successfully', 'message' => 'Your email address has been changed successfully.']);
	}
}