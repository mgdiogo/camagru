<?php
require_once __DIR__ . '/../core/Database.php';

try {
	$db = new Database();
	echo "<h3>Connected successfully to: " . DB_NAME . "</h3>";
} catch (PDOException $e) {
	echo "<h3>Connection failed:</h3> " . $e->getMessage();
}
