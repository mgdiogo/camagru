<?php

require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Mail.php';

class UserController extends Controller
{

	private $userModel;
	private $verificationModel;

	public function __construct() {
		$this->userModel = new UserModel;
		$this->verificationModel = new VerificationModel;
	}

	public function register(): void {
		// Set content to JSON for API Responses
		header('Content-Type: application/json');

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			http_response_code(405);
			echo json_encode(['error' => '405: Method not allowed']);
			exit;
		}

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

		$user = $this->userModel->getUserByEmailOrUsername($data['email'], $data['username']);

		if ($user) {
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

		if ($id = $this->userModel->register($data)) {
			$verificationToken = $this->verificationModel->generateEmailVerificationToken($id); 
			sendEmailVerification($data['username'], $data['email'], $verificationToken);
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

	public function editProfile() {
		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			http_response_code(405);
			echo json_encode(['error' => '405: Method not allowed']);
			exit;
		}

		$user = $this->userModel->getUserById($_SESSION['user_id']);

		if (!$user) {
			header('Location: /login');
			exit;
		}

		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$data = [
			'username' => isset($_POST['username']) && $_POST['username'] !== '' ? trim($_POST['username']) : null,
    		'email' => isset($_POST['email']) && $_POST['email'] !== '' ? trim($_POST['email']) : null
		];

		if (!empty($_FILES['avatar']['name'])) {
			$avatar = $this->validateAvatar($_FILES['avatar']);
			if (!$avatar['success']) {
				http_response_code(400);
				echo json_encode([
					'success' => false,
					'message' => $avatar['message'],
					'field' => 'avatar'
				]);
				return;	
			}
			$extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
			$avatar_name = bin2hex(random_bytes(16));
			$final = "{$avatar_name}.{$extension}";

			$uploadAvatar = move_uploaded_file($_FILES['avatar']['tmp_name'], PUB_ROOT_DIR . "/uploads/avatars/{$final}");
			if (!$uploadAvatar) {
				error_log("Error uploading avatar");
				return;
			}
			$this->userModel->setAvatar($_FILES['avatar']);
		}

		$existingUser = $this->userModel->getUserByEmailOrUsername($data['email'], $data['username']);

		if ($existingUser) {
			http_response_code(409);
			echo json_encode([
				'success' => false,
				'message' => 'Username or email already taken',
				'field' => 'username'
			]);
			return;
		}

		if ($data['username'] !== null) {
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
			$this->userModel->updateUsername($data['username'], $user->id);
		}

		if ($data['email'] !== null) {
			if (!preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/', $data['email'])) {
				http_response_code(400);
				echo json_encode([
					'success' => false,
					'message' => 'Please enter a valid email address',
					'field' => 'email'
				]);
				return;
			}
			$updateToken = $this->userModel->generateUpdateEmailToken($user->id);
			$this->userModel->setTempEmail($data['email'], $user->id);
			if ($data['username'] !== null) {
				sendChangeEmail($data['username'], $data['email'], $updateToken);
				return;
			}
			sendChangeEmail($user->username, $data['email'], $updateToken);
		}

		echo json_encode([
			'success' => true,
			'message'=> 'Info updated successfully',
			'redirect'=> '/profile'
		]);
	}

	public function validateAvatar($avatar) {
		if (empty($avatar['name'] || $avatar['error'] !== UPLOAD_ERR_OK))
			return ['message' => 'Please select a file', 'success' => false];

		$file_info = new finfo(FILEINFO_MIME_TYPE);
		$mime_type = $file_info->file($avatar['tmp_name']);

		$allowed_types = ['image/jpeg', 'image/pjpeg', 'image/png'];

		if (!in_array($mime_type, $allowed_types))
			return ['message' => 'File not supported', 'success' => false];

		$max_size = 2 * 1024 * 1024;

		if ($avatar['size'] > $max_size)
			return ['message' => 'Image must not be larger than 2MB', 'success' => false];

		return ['success' => true];
	}
}
