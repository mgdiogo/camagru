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
					<?php
					$props = [
						'id' => 'edit_btn',
						'icon' => '/images/edit.svg',
						'text' => 'Edit Profile'
					];
					include '../app/views/components/secondaryBtn.php';

					$props = [
						'id' => 'password_btn',
						'icon' => '/images/lock.svg',
						'text' => 'Change Password'
					];
					include '../app/views/components/secondaryBtn.php';

					$props = [
						'id' => 'delete_btn',
						'icon'=> '/images/delete.svg',
						'text' => 'Delete Account'
					];
					include '../app/views/components/negativeBtn.php';;
					?>
				</div>
			</div>
			<div class="bg-[#D5D5D5] border-t"></div>
			<div class="flex flex-row w-full gap-2.5 p-8">
				<div class="flex pl-4 pr-[2.5rem]">
					<img class="w-[100px] h-[100px] rounded-2xl border-2" src="/uploads/avatars/<?= htmlspecialchars($avatar) ?>">
				</div>
				<div class="flex flex-col gap-6">
					<?php
					$props = [
						'label' => 'Username',
						'text' => $username,
						'input' => false
					];
					include '../app/views/components/inputField.php';

					$props = [
						'label' => 'Email',
						'text' => $email,
						'input' => false
					];
					include '../app/views/components/inputField.php';
					?>
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
					<form method="POST" enctype="multipart/form-data" class="flex flex-col gap-6 w-full max-w-2xl" id="editProfileForm">
						<div class="flex flex-row items-center gap-2">
							<img id="user_avatar" class="w-[120px] h-[120px] rounded-2xl border-2" src="/uploads/avatars/<?= htmlspecialchars($avatar) ?>">
							<label for="avatar" class="cursor-pointer w-fit">
								<div class="flex flex-row items-center rounded-2xl py-2 p-2.5 gap-2">
									<img class="w-4 h-4" src="/images/upload_avatar.svg">
									<p class="font-medium font-[Montserrat] text-sm">Upload picture</p>
								</div>
							</label>
						</div>
						<p class="text-[#AA1616] font-medium font-[Montserrat] text-sm hidden" id="avatarError"></p>
						<input type="file" id="avatar" name="avatar" accept="image/jpg, image/png, image/jpeg" class="hidden">
						<?php
						$props = [
							'label' => 'Username',
							'type' => 'text',
							'id' => 'username',
							'name' => 'username',
							'errorId' => 'usernameError',
							'input' => true
						];
						include '../app/views/components/inputField.php';

						$props = [
							'label' => 'Email',
							'type' => 'text',
							'id' => 'email',
							'name' => 'email',
							'errorId' => 'emailError',
							'input' => true
						];
						include '../app/views/components/inputField.php';
						?>
					</form>
				</div>
				<div class="bg-[#D5D5D5] border-t"></div>
				<div class="flex py-3 px-5 justify-end">
					<div class="flex flex-row gap-2">
						<?php
						$props = [
							'id' => 'send_edit_btn',
							'type' => 'submit',
							'icon' => '/images/save.svg',
							'text' => 'Save Profile',
							'form' => 'editProfileForm',
							'disabled' => true
						];
						include '../app/views/components/primaryBtn.php';

						$props = [
							'id' => 'cancel_edit_profile',
							'text' => 'Cancel',
						];
						include '../app/views/components/secondaryBtn.php';
						?>
					</div>
				</div>
			</div>
		</div> 
	</main>
	<script type="module" src="/js/editProfile.js"></script>
</body>