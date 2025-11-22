<div id="edit_modal" class="hidden fixed inset-0 bg-black/50 flex flex-col justify-center items-center">
	<div id="edit_profile" class="bg-white flex flex-col w-full max-w-2xl mx-auto rounded-2xl shadow-[0_2px_8px_0_#00000014]">
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