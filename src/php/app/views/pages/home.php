<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Camagru</title>
	<link rel="icon" type="image/x-icon" href="images/icon.svg">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen overflow-hidden bg-gradient-to-r from-blue-500 via-purple-500
			   to-pink-500">
	<div class="flex flex-col lg:flex-row center-items justify-center h-screen p-8 md:p-16 lg:p-32">
		<div class="hidden lg:flex w-1/2 center-items justify-center">
			<img class="object-scale-down md:object-cover w-full h-full rounded-l-xl shadow-lg" src="images/p3.jpg"
				alt="login_img" id="login_img">
		</div>
		<div
			class="lg:w-1/2 bg-white rounded-xl lg:rounded-none lg:rounded-r-xl shadow-lg text-center flex flex-col p-4 md:p-8 lg:p-16">
			<h1 class="text-black text-3xl pb-4">
				Camagru
			</h1>
			<p>
				Your social media where sharing photos has never been more fun!
			</p>
			<form action="" class="p-4">
				<label for="username" class="block mt-4 mb-2 text-left text-gray-700 font-bold">Username:</label>
				<input type="text" id="username" name="username" placeholder="Enter your username"
					class="block w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
				<label for="username" class="block mt-4 mb-2 text-left text-gray-700 font-bold">Email:</label>
				<input type="email" id="email" name="email" placeholder="Enter your email"
					class="block w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
				<label for="password" class="block mt-4 mb-2 text-left text-gray-700 font-bold">Password:</label>
				<input type="password" id="password" name="password" placeholder="Enter your password"
					class="block w-full mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
				<label for="confirm_password" class="block mt-4 mb-2 text-left text-gray-700 font-bold">Confirm
					Password:</label>
				<input type="password" id="confirm_password" name="confirm_password" placeholder="Enter your password"
					class="block w-full mb-6 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
				<button type="button"
					class="w-1/3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600">Register</button>
			</form>
		</div>
	</div>
</body>

<!---
	TODO:
		- Fix horizontal responsive design on mobile & iPad view
--->