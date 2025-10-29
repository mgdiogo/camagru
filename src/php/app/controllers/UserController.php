<?php

require_once __DIR__ . '/../core/Controller.php';

class UserController extends Controller {

	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel();
	}

	public function register(): void {

		// Sanitize data sent from POST
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
			//TODO
		}

		$data = [
			'username' => trim($_POST['username']),
			'email' => trim($_POST['email']),
			'password' => trim($_POST['password']),
			'confirm_password' => trim($_POST['confirm_password'])
		];

	}
}

$init = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	switch ($_POST['type']) {
		case 'register':
			$init->register();
			break;
	}
}