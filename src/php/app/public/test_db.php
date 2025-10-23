<?php
require_once __DIR__ . '/../core/Database.php';

try {
	echo "<pre>"; print_r(DB_NAME); echo "</pre>";
	$db = new Database();
	$pdo = $db->connect();
	echo "<h3>Connected successfully to: " . DB_NAME . "</h3>";
} catch (PDOException $e) {
	echo "<h3>Connection failed:</h3> " . $e->getMessage();
}
