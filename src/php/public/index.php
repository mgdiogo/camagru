<?php

require_once __DIR__ . '/../app/core/config.php';

// Autoloading for performance

spl_autoload_register(function ($class) {
	$paths = ['../app/core/', '../app/controllers/', '../app/models/'];
	foreach ($paths as $path) {
		$file = __DIR__ . "/{$path}{$class}.php";
		if (file_exists($file)) {
			require_once $file;
			return;
		}
	}
});

validateSession();

// Define Routes

$routes = [
	'/' => [
		'controller' => 'HomeController',
		'method' => 'signup'
	],
	'/signup'=> [
		'controller' => 'HomeController',
		'method' => 'signup'
	],
	'/login'=> [
		'controller' => 'HomeController',
		'method' => 'login'
	],
	'/not_found' => [
		'controller' => 'ErrorController',
		'method' => 'not_found'
	],
	'/user/register' => [
		'controller' => 'UserController',
		'method' => 'register'
	],
	'/profile' => [
		'controller' => 'ProfileController',
		'method' => 'profile'
	 ],
	 '/profile/edit' => [
		'controller' => 'UserController',
		'method' => 'editProfile'
	 ],
	'/verify' => [
		'controller' => 'VerificationController',
		'method' => 'verify'
	],
	'/auth/login' => [
		'controller' => 'AuthController',
		'method' => 'login'
	],
	'/logout' => [ 
		'controller' => 'AuthController',
		'method' => 'logout'
	]
];

try {
	$router = new Router($routes);
	$router->handleRequest();
} catch (Throwable $e) {
	error_log($e);
	http_response_code(500);
	$controller = new ErrorController();
	$controller->server_error();
	exit;
}