<?php

define('DB_HOST',getenv('MYSQL_HOST'));
define('DB_NAME', getenv('MYSQL_DATABASE'));
define('DB_USER', getenv('MYSQL_USER'));
define('DB_PASSWORD', getenv('MYSQL_PASSWORD'));

ini_set('session.use_only_cookies','1');
ini_set('session.use_strict_mode','1');

session_name('session');

session_set_cookie_params([
	'lifetime' => '18000',
	'domain' => 'localhost',
	'path' => '/',
	'secure' => false,
	'httponly' => true,
	'samesite' => 'Lax'
]);

function validateSession() {
	if (session_status() === PHP_SESSION_NONE)
		session_start();

	if (!isset($_SESSION['last_activity'])) { 
		session_regenerate_id(true);
		$_SESSION['lreg'] = time();
	} else {
		$interval = 60 * 30;
	
		if (time() - $_SESSION['last_activity'] >= $interval) {
			session_regenerate_id(true);
			$_SESSION['last_activity'] = time();
		}
	}
}
