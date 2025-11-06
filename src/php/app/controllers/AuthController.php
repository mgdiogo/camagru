<?php

require_once __DIR__ . '/../core/Controller.php';

class AuthController extends Controller {

	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel;
	}
	public function login() {
		header('Content-Type: application/json');

		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$data = [
			'username' => trim($_POST['username'] ?? ''),
			'password' => trim($_POST['password'] ?? '')
		];

		if (empty($data['username']) || empty($data['password'])) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Missing fields',
			]);
			return;
		}

		$user = $this->userModel->getUserByEmailOrUsername($data['username'], $data['username']);

		if ($user) {
			if (password_verify($data['password'], $user->password)) {
				if (!$user->verified) {
					http_response_code(400);
					echo json_encode([
					'success' => false,
					'verified' => false,
					'message' => 'Verification has not been completed, check your email'
					]);
					return;
				}
				session_regenerate_id(true);
				$_SESSION['user_id'] = $user->id;
				http_response_code(200);
				echo json_encode([
					'success' => true,
					'message' => 'Login successful',
					'redirect' => '/feed'
				]);
			} else {
				http_response_code(400);
				echo json_encode([
					'success' => false,
					'message' => 'Invalid credentials',
				]);
			}
		} else {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Invalid credentials',
			]);
		}
	}

	public function logout() {
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params["path"],
				$params["domain"],
				$params["secure"],
				$params["httponly"]
			);
		}

		if (session_status() === PHP_SESSION_NONE)
			session_start();

		session_unset();
		session_destroy();
	
		header('Location: /login');
		exit;
	}

	public static function redirect($url) {
		header("Location: $url");
		exit;
	}
	
	public static function validateUser() {
		$userId = $_SESSION['user_id'] ?? null;
		if (!$userId || !is_numeric($userId)) {
			session_destroy();
			AuthController::redirect('/login');
		}
	}
	
	public static function isLoggedIn() {
		if (isset($_SESSION['user_id']))
			AuthController::redirect('/feed');
	}
}