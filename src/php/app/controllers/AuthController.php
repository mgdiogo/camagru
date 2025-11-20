<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Mail.php';

class AuthController extends Controller {

	private $userModel;
	private $verificationModel;

	public function __construct() {
		$this->userModel = new UserModel;
		$this->verificationModel = new VerificationModel;
	}
	public function login() {
		header('Content-Type: application/json');

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			http_response_code(405);
			echo json_encode(['error' => '405: Method not allowed']);
			exit;
		}

		$contentType = $_SERVER['CONTENT_TYPE'] ?? '';

		if (strpos($contentType, 'application/json') !== false)
			$input = json_decode(file_get_contents('php://input'), true);
		else
			$input = $_POST;

		$data = [
			'username' => trim($input['username'] ?? ''),
			'password' => trim($input['password'] ?? '')
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
					$tokenData = $this->verificationModel->getLatestEmailVerificationToken($user->id);
					if ($tokenData) {
						if (strtotime($tokenData->expires_at) > time()) {
							http_response_code(403);
							echo json_encode([
							'success' => false,
							'verified' => false,
							'message' => 'Email is not verified, check your inbox'
							]);
							return;
						}
					}
					$newToken = $this->verificationModel->generateEmailVerificationToken($user->id);
					sendEmailVerification($user->username, $user->email , $newToken);
					http_response_code(403);
					echo json_encode([
					'success' => false,
					'verified' => false,
					'message' => 'Previous verification link expired, a new one has been sent to your email'
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
				http_response_code(401);
				echo json_encode([
					'success' => false,
					'message' => 'Invalid credentials',
				]);
			}
		} else {
			http_response_code(401);
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