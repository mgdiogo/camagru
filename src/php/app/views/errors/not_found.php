<!DOCTYPE html>

<?php
	include_once '../app/views/templates/head.php'
?>

<body class="md:bg-[url(/images/bg_home.jpg)] bg-cover bg-center bg-no-repeat min-h-screen">
	<div class="w-full min-h-screen flex flex-col justify-center items-center md:p-8">
		<div class="flex flex-wrap md:flex-nowrap bg-white w-full max-w-6xl h-screen md:h-auto md:max-h-[768px] justify-center items-center md:rounded-xl
			md:shadow-[0px_5px_15px_rgba(0,0,0,0.35)]">
			<div class="flex flex-col md:flex-row justify-center items-center w-full md:min-h-screen max-w-sm md:max-w-2xl">
				<img class="w-1/2 md:w-full max-w-sm" src="/images/404.png">
				<div class="flex flex-col w-full">
					<span class="text-center md:text-left font-[Montserrat] font-bold text-3xl">Page not found</span>
					<span class="pt-4 text-center md:text-left font-[Montserrat] text-xl">We couldn't find the page you are looking for.</span>
					<a href="/" class="pt-4 text-center md:text-left font-[Montserrat] text-xl">Go to <span class="cursor-pointer hover:underline text-blue-600 font-semibold">homepage.</span></a>
				</div>
			</div>
		</div>
	</div>
</body>