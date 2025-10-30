<?php

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
	'/user/login' => [
		'controller' => 'UserController',
		'method' => 'login'
	]
];

try {
	$router = new Router($routes);
	$router->handleRequest();
} catch (Throwable $e) {
	error_log($e);
	http_response_code(500);
	require_once '../app/controllers/ErrorController.php';
	$controller = new ErrorController();
	$controller->server_error();
	exit;
}