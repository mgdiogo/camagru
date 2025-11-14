<?php
require_once __DIR__ . '/../app/core/database.php';

try {
	$db = new Database();
	echo "<h3>Connected successfully to: " . DB_NAME . "</h3>";
} catch (PDOException $e) {
	echo "<h3>Connection failed:</h3> " . $e->getMessage();
}
