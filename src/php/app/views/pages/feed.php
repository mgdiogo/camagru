<?php
include_once '../app/controllers/AuthController.php';
AuthController::validateUser();
include_once '../app/views/templates/header.php';
?>

<!DOCTYPE html>

<body class="min-h-screen flex flex-col">
	<header>
		<nav class="bg-[#3d3a2c] relative">
			<div class="flex flex-row items-center justify-between p-4 md:pl-8 md:pr-8">
				<a href="/" class="flex col-span-6 items-center space-x-3">
					<img class="h-8" src="images/logo_white_bg.svg">
				</a>
				<div class="hidden md:flex items-center justify-center gap-8">
					<a href="/post"
						class="w-7 h-7 flex items-center justify-center rounded-full bg-[#4F9E91] hover:bg-[#EBCD6E] shadow-lg transition-all duration-200">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white font-[Montserrat]" fill="none"
							viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
						</svg>
					</a>
					<a href="/profile"
						class="text-[#EBE1C5] hover:text-[#4F9E91] transition-colors duration-200 font-semibold font-[Montserrat] text-lg">
						Profile
					</a>
					<a href="/logout"
						class="text-[#ED834E] hover:text-[#EBCD6E] transition-colors duration-200 font-semibold font-[Montserrat] text-lg">
						Logout
					</a>
				</div>
				<div class="md:hidden">
					<button id="mobile-menu-button" class="focus:outline-none">
						<svg class="w-6 h-6 text-[#EBE1C5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M4 6h16M4 12h16M4 18h16" />
						</svg>
					</button>
				</div>
				<div id="mobile-menu"
					class="hidden absolute top-full left-0 w-full bg-[#3d3a2c]/70 backdrop-blur-md shadow-lg z-50 flex flex-col items-center transition-all duration-300 ease-in-out transform scale-y-0 origin-top">
					<a href="/post"
						class="block px-4 py-3 text-[#EBE1C5] font-bold hover:bg-[#4F9E91] hover:text-[#3D3A2C] transition-colors duration-200">New
						Post</a>
					<a href="/profile"
						class="block px-4 py-3 text-[#EBE1C5] hover:bg-[#4F9E91] hover:text-[#3d3a2c] transition-colors duration-200">Profile</a>
					<a href="/logout"
						class="block px-4 py-3 text-[#ED834E] hover:bg-[#EBCD6E] hover:text-[#3d3a2c] transition-colors duration-200">Logout</a>
				</div>
			</div>
		</nav>
	</header>
	<div class="flex-1 bg-[#fdf8ef] flex flex-col w-full lg:max-w-xl xl:max-w-[1280px] mx-auto shadow-2xl">

	</div>
	<footer class="bg-[#3d3a2c] text-center text-white p-4">
		<p class="font-semibold font-[Montserrat]">2025 Camagru</p>
	</footer>
	<script src="/js/navbar.js"></script>
</body>