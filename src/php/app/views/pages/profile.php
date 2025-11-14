<?php
	include_once '../app/controllers/AuthController.php';
	AuthController::validateUser();
	include_once '../app/views/templates/head.php';
?>

<body class="min-h-screen flex flex-col bg-[#F5F5F5]">
	<?php include_once '../app/views/templates/header.php'?>
	<main class="flex p-16 gap-8">
		<div class="bg-white flex flex-col w-full xl:max-w-[1040px] mx-auto rounded-2xl shadow-[0_2px_8px_0_#00000014]">
			<div class="flex flex-row justify-between py-5 px-6">
				<p class="font-[Montserrat] font-bold text-2xl">My Profile</p>
				<div class="flex flex-row gap-2.5">
					<button class="flex font-medium font-[Montserrat] text-sm justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 hover:bg-[#E9E9E9]"><img class="w-4 h-4" src="/images/edit.svg">Edit Profile</button>
					<button class="flex font-medium font-[Montserrat] text-sm justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 hover:bg-[#E9E9E9]"><img class="w-4 h-4" src="/images/lock.svg">Change Password</button>
					<button class="flex font-medium font-[Montserrat] text-sm text-[#AA1616] justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 bg-[#FFEAEA] hover:bg-[#E9E9E9]"><img class="w-4 h-4" src="/images/delete.svg">Delete Account</button>
				</div>
			</div>
			<div class="bg-[#D5D5D5] border-t"></div>
			<div class="flex flex-row w-full gap-2.5 p-8">
				<div class="flex pl-4 pr-[2.5rem]">
					<img class="w-[100px] h-[100px] rounded-2xl" src="/images/test_image.png">
				</div>
				<div class="flex flex-col gap-6">
					<div class="flex flex-col gap-2">
						<p class="font-medium font-[Montserrat] text-sm">Username</p>
						<p class="font-bold font-[Montserrat] text-xl"><?= htmlspecialchars($username)?></p>
					</div>
					<div class="flex flex-col gap-2">
						<p class="font-medium font-[Montserrat] text-sm">Email</p>
						<p class="font-bold font-[Montserrat] text-xl"><?= htmlspecialchars($email)?></p>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="/js/navbar.js"></script>
</body>