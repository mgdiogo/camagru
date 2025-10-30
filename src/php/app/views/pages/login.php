<?php
	session_start();
	include_once '../app/views/templates/header.php'
?>

<!DOCTYPE html>

<body class="min-h-screen bg-[url(/images/bg_home.jpg)] bg-cover bg-center bg-no-repeat">
	<div class="flex flex-col lg:flex-row justify-center min-h-screen p-8 lg:p-0">
		<div class="hidden lg:flex w-1/2 justify-center">
			<img class="object-cover w-full h-full shadow-lg" src="/images/bg_home.jpg" alt="login_img" id="login_img">
		</div>
		<div class="lg:w-1/2 bg-white rounded-xl lg:rounded-none justify-center shadow-lg flex flex-col p-4 md:p-8 lg:p-16">
			<div class="flex justify-center p-8">
				<img class="max-w-64 md:max-w-xs" src="images/logo_brown.svg">
			</div>
			<form method="POST" class="flex flex-col items-center" id="signinForm">
				<input type="hidden" name="type" value="login">
				<div class="w-full md:w-96 flex flex-col justify-center">
					<label for="username"
						class="block mt-4 mb-2 text-gray-700 font-bold font-[Montserrat]">Username:</label>
					<input type="text" id="username" name="username" placeholder="Enter your username"
						class="block mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500">
					<p class="text-red-600 text-sm hidden mt-1 mb-3" id="usernameError">Username is required</p>
					<label for="password"
						class="block mt-4 mb-2 text-left text-gray-700 font-bold font-[Montserrat]">Password:</label>
					<input type="password" id="password" name="password" placeholder="Enter your password"
						class="block mb-6 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
					<p class="text-red-600 text-sm hidden mt-1 mb-3" id="passwordError">Password is required</p>
				</div>
				<button type="submit" name="login_btn"
					class="w-1/2 md:w-1/3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-bold font-[Montserrat] rounded-lg text-md px-5 py-2.5 mt-2 dark:bg-blue-600">Login</button>
				<span class="py-4 text-center font-[Montserrat]">Don't have an account? <a href="/signup"
						class="cursor-pointer hover:underline text-blue-600 font-[Montserrat] font-semibold">Sign up</a></span>
			</form>
		</div>
	</div>
	<script src="/js/login.js"></script>
</body>