<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/UserModel.php';

class VerificationController extends Controller {

	private $userModel;

	public function __construct() { 
		$this->userModel = new UserModel();
	}

	public function index() {
		$token = $_GET['token'];

		$user = $this->userModel->getUserByToken($token);

		if (!$token || !$user) {
			$this->render('/pages/invalid_verification', ['title' => 'Camagru']);
			return;
		} else if ($user->verified) {
			$this->render('/pages/user_already_verified', ['title' => 'Camagru']);
			return;
		}
		$this->userModel->setVerified($user->id);
		$this->render('/pages/successful_verification', ['title' => 'Camagru']);
	}
}