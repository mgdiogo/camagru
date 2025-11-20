<?php

require_once __DIR__ . '/../core/Controller.php';

class VerificationController extends Controller {

	private $userModel;
	private $tokenModel;

	public function __construct() { 
		$this->userModel = new UserModel;
		$this->tokenModel = new TokenModel;
	}

	public function verify() {
		$token = $_GET['token'];

		$user = $this->tokenModel->getEmailVerificationToken($token);

		if (!$token || !$user) {
			$this->render('/pages/verification', ['title' => 'Camagru', 'image' => '/images/404.png', 'result_title' => 'Invalid or expired link', 'message' => 'Invalid account verification request.']);
			return;
		} else if ($user->verified) {
			$this->render('/pages/verification', ['title' => 'Camagru', 'image' => '/images/404.png', 'result_title' => 'User already verified', 'message' => 'You should already be able to login using your credentials.']);
			return;
		}
		$this->userModel->setVerified($user->id);
		$this->render('/pages/verification', ['title' => 'Camagru', 'image' => '/images/success.jpg', 'result_title' => 'Verification successful', 'message' => 'You should now be able to login using your credentials.']);
	}
}