<?php
	include_once '../app/controllers/AuthController.php';
	AuthController::validateUser();
	include_once '../app/views/templates/header.php';
?>

<!DOCTYPE html>

<body class="min-h-screen flex flex-col">
	<header>
		<nav class="bg-[#3d3a2c]">
			<div class="flex flex-row items-center justify-between p-4 md:pl-8">
				<a href="/" class="flex col-span-6 items-center space-x-3">
					<img class="h-8" src="images/logo_white_bg.svg">
				</a>
				<div class="flex items-center justify-center gap-6">
					<a href="/post">+</a>
					<a href="/profile">Profile</a>
					<a href="/logout">Logout</a>
				</div>
			</div>
		</nav>
	</header>
	<div class="flex-1 bg-[#fdf8ef] flex flex-col w-full lg:max-w-xl xl:max-w-[1280px] mx-auto shadow-2xl">

	</div>
</body>

<footer class="bg-[#3d3a2c] text-center text-white py-4">
	<p>2025 Camagru</p>
</footer>