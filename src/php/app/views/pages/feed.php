<?php
	include_once '../app/controllers/AuthController.php';
	AuthController::validateUser();
	include_once '../app/views/templates/head.php';
?>

<body class="min-h-screen flex flex-col">
	<?php include_once '../app/views/templates/header.php'?>
	<main class="flex flex-col justify-center min-h-screen">
		<div class="flex-1 bg-[#fdf8ef] flex flex-col w-full lg:max-w-xl xl:max-w-[1280px] mx-auto shadow-2xl">
	
		</div>
		<footer class="bg-[#3d3a2c] text-center text-white p-4">
			<p class="font-semibold font-[Montserrat]">2025 Camagru</p>
		</footer>
	</main>
	<script src="/js/navbar.js"></script>
</body>