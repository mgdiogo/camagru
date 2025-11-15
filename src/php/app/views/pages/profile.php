<?php
	include_once '../app/controllers/AuthController.php';
	AuthController::validateUser();
	include_once '../app/views/templates/head.php';
?>

<body class="min-h-screen flex flex-col bg-[#F5F5F5]">
	<?php include_once '../app/views/templates/header.php'?>
	<main class="flex p-16 gap-8">
		<div id="profile" class="bg-white flex flex-col w-full xl:max-w-[1040px] mx-auto rounded-2xl shadow-[0_2px_8px_0_#00000014]">
			<div class="flex flex-row justify-between py-5 px-6">
				<p class="font-[Montserrat] font-bold text-2xl">My Profile</p>
				<div class="flex flex-row gap-2.5">
					<button id="edit_btn" class="flex font-medium font-[Montserrat] text-sm justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 hover:bg-[#E9E9E9]"><img class="w-4 h-4" src="/images/edit.svg">Edit Profile</button>
					<button id="password_btn" class="flex font-medium font-[Montserrat] text-sm justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 hover:bg-[#E9E9E9]"><img class="w-4 h-4" src="/images/lock.svg">Change Password</button>
					<button id="delete_btn" class="flex font-medium font-[Montserrat] text-sm text-[#AA1616] justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5 bg-[#FFEAEA] hover:bg-[#F3DCDC]"><img class="w-4 h-4" src="/images/delete.svg">Delete Account</button>
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
		<div id="edit_profile" class="hidden fixed inset-0 bg-black/50 flex flex-col justify-center items-center">
			<div id="edit_modal" class="bg-white flex flex-col w-full max-w-2xl mx-auto rounded-2xl shadow-[0_2px_8px_0_#00000014]">
				<div class="flex justify-start py-3 px-5">
					<p class="font-[Montserrat] font-bold text-xl">Edit Profile</p>
				</div>
				<div class="bg-[#D5D5D5] border-t"></div>
				<div class="flex flex-row p-8 gap-2">
					<form method="POST" class="flex flex-col gap-6 w-full max-w-2xl" id="editProfileForm">
						<label for="avatar" class="cursor-pointer w-fit">
							<div class="flex flex-row items-center gap-2">
								<img class="w-[120px] h-[120px] rounded-2xl" src="/images/test_image.png">
								<div class="flex flex-row items-center rounded-2xl py-2 p-2.5 gap-2">
									<img class="w-4 h-4" src="/images/upload_avatar.svg">
									<p class="font-medium font-[Montserrat] text-sm">Upload picture</p>
								</div>
							</div>
						</label>
						<input type="file" id="avatar" accept="image/*" class="hidden">
						<div class="flex flex-col gap-2">
							<label class="font-medium font-[Montserrat] text-[#3E3E3E] text-sm">Username</label>
							<input type="text" id="username" name="username" class="block flex font-normal font-[Montserrat] text-sm rounded-lg border border-[#A6A6A6] py-3.5 px-[1.125rem] gap-2.5 h-11">
							<p class="text-[#AA1616] font-medium font-[Montserrat] text-sm hidden" id="usernameError"></p>
						</div>
						<div class="flex flex-col gap-2">
							<label class="font-medium font-[Montserrat] text-[#3E3E3E] text-sm">Email</label>
							<input type="text" id="email" name="email" class="block flex font-normal font-[Montserrat] text-sm rounded-lg border border-[#A6A6A6] py-3.5 px-[1.125rem] gap-2.5 h-11">
							<p class="text-[#AA1616] font-medium font-[Montserrat] text-sm hidden" id="emailError"></p>
						</div>
					</form>
				</div>
				<div class="bg-[#D5D5D5] border-t"></div>
				<div class="flex py-3 px-5 justify-end">
					<div class="flex flex-row gap-2">
						<button disabled type="submit" form="editProfileForm" id="send_edit_btn" class="flex font-medium font-[Montserrat] text-sm justify-center items-center rounded-md h-8 py-2 px-2.5 gap-2 bg-[#444444] hover:bg-[#444444] text-white"><img class="w-4 h-4" src="/images/save.svg">Save Profile</button>
						<button id="cancel_edit_profile" class="flex font-medium font-[Montserrat] text-sm justify-center items-center rounded-md h-8 py-2 px-2.5 gap-2 hover:bg-[#E9E9E9] text-black">Cancel</button>
					</div>
				</div>
			</div>
		</div> 
	</main>
	<script src="/js/profile.js"></script>
</body>