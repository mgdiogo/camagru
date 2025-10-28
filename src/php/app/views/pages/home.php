<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?= htmlspecialchars($title) ?></title>
	<link rel="icon" type="image/x-icon" href="images/icon_camagru.svg">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[url(./images/bg_home.jpg)] bg-cover bg-center bg-no-repeat">
	<div class="flex flex-col lg:flex-row center-items justify-center min-h-screen p-8 lg:p-0">
		<div class="hidden lg:flex w-1/2 center-items justify-center">
			<img class="object-cover w-full h-full shadow-lg" src="images/bg_home.jpg" alt="login_img" id="login_img">
		</div>
		<div class="lg:w-1/2 bg-white rounded-xl lg:rounded-none shadow-lg flex flex-col p-4 md:p-8 lg:p-16">
			<div class="flex justify-center center-items">
				<img class="max-w-64 md:max-w-xs" src="images/logo_brown.svg">
			</div>
			<h1 class="pt-8 pb-8 font-bold font-[Montserrat] text-center text-md md:text-2xl">Your social media where sharing
				photos has never been more fun!</h1>
			<form action="" class="flex flex-col items-center">
				<div class="w-full md:w-96 flex flex-col justify-center">
					<label for="username" class="block mt-4 mb-2 text-gray-700 font-bold font-[Montserrat]">Username:</label>
					<input type="text" id="username" name="username" placeholder="Enter your username"
						class="block mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
					<label for="username"
						class="block mt-4 mb-2 text-left text-gray-700 font-bold font-[Montserrat]">Email:</label>
					<input type="email" id="email" name="email" placeholder="Enter your email"
						class="block mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
					<label for="password"
						class="block mt-4 mb-2 text-left text-gray-700 font-bold font-[Montserrat]">Password:</label>
					<input type="password" id="password" name="password" placeholder="Enter your password"
						class="block mb-4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
					<label for="confirm_password"
						class="block mt-4 mb-2 text-left text-gray-700 font-bold font-[Montserrat]">Confirm
						Password:</label>
					<input type="password" id="confirm_password" name="confirm_password"
						placeholder="Enter your password"
						class="block mb-6 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-gray-500 required">
				</div>
				<button type="button"
					class="w-1/2 md:w-1/3 text-white bg-blue-700 hover:bg-blue-800 focus:ring-2 focus:ring-blue-300 font-bold font-[Montserrat] rounded-lg text-md px-5 py-2.5 mt-2 mb-2 dark:bg-blue-600">Register</button>
			</form>
			<p class="py-4 text-center font-[Montserrat]">Already registered? <button type="button"
					class="hover:underline text-blue-600">Login</button></p>
		</div>
	</div>
</body>