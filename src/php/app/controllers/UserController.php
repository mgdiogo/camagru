<?php

require_once __DIR__ . '/../core/Controller.php';

class UserController extends Controller
{

	private $userModel;

	public function __construct() {
		$this->userModel = new UserModel;
	}

	public function register(): void {

		// Set content to JSON for API Responses
		header('Content-Type: application/json');

		// Sanitize data sent from POST
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$data = [
			'username' => trim($_POST['username'] ?? ''),
			'email' => trim($_POST['email'] ?? ''),
			'password' => trim($_POST['password'] ?? ''),
			'confirm_password' => trim($_POST['confirm_password'] ?? '')
		];

		if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Missing fields',
			]);
			return;
		}

		if (strlen($data['username']) < 4 || strlen($data['username']) > 25) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Username must have between 4 and 25 characters',
				'field' => 'username'
			]);
			return;
		}

		if (!preg_match('/[a-zA-Z]/', $data['username'])) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Username must contain atleast one letter',
				'field' => 'username'
			]);
			return;
		}

		if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $data['email'])) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Please enter a valid email address',
				'field' => 'email'
			]);
			return;
		}

		if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,50}$/', $data['password'])) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Password is not strong enough',
				'field' => 'password'
			]);
			return;
		}

		if ($data['confirm_password'] !== $data['password']) {
			http_response_code(400);
			echo json_encode([
				'success' => false,
				'message' => 'Password does not match',
				'field' => 'confirm_password'
			]);
			return;
		}

		if ($this->userModel->getUserByEmailOrUsername($data['email'], $data['username'])) {
			http_response_code(409);
			echo json_encode([
				'success' => false,
				'message' => 'Username or email already taken',
				'field_one' => 'email',
				'field_two' => 'username'
			]);
			return;
		}

		// Hashing password, using PASSWORD_DEFAULT automatically uses the most recent hashing algorithm so it's recommended
		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

		if ($this->userModel->register($data)) {
			http_response_code(201);
			echo json_encode([
				'success' => true,
				'message' => 'Registration successful',
				'redirect' => '/login'
			]);
		} else {
			http_response_code(500);
			echo json_encode([
				'success' => false,
				'message' => 'Something went wrong..',
				'redirect' => '/server_error'
			]);
		}
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
}
