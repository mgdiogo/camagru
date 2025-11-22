<div id="change_password_modal" class="hidden fixed inset-0 bg-black/50 flex flex-col justify-center items-center">
	<div id="change_password" class="bg-white flex flex-col w-full max-w-2xl mx-auto rounded-2xl shadow-[0_2px_8px_0_#00000014]">
		<div class="flex justify-start py-3 px-5">
			<p class="font-[Montserrat] font-bold text-xl">Change Password</p>
		</div>
		<div class="bg-[#D5D5D5] border-t"></div>
		<div class="flex flex-row p-8 gap-2">
			<form method="POST" class="flex flex-col gap-6 w-full max-w-2xl" id="changePasswordForm">
				<?php
				$props = [
					'label' => 'Current Password',
					'type' => 'password',
					'id' => 'current_pw',
					'name' => 'current_pw',
					'errorId' => 'passwordError',
					'input' => true
				];
				include '../app/views/components/inputField.php';

				$props = [
					'label' => 'New Password',
					'type' => 'password',
					'id' => 'new_pw',
					'name' => 'new_pw',
					'errorId' => 'newPasswordError',
					'input' => true
				];
				include '../app/views/components/inputField.php';
				$props = [
					'label' => 'Confirm Password',
					'type' => 'password',
					'id' => 'confirm_pw',
					'name' => 'confirm_pw',
					'errorId' => 'confirmPasswordError',
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
					'id' => 'change_password_btn',
					'type' => 'submit',
					'icon' => '/images/save.svg',
					'text' => 'Save',
					'form' => 'changePasswordForm',
					'disabled' => true
				];
				include '../app/views/components/primaryBtn.php';

				$props = [
					'id' => 'cancel_btn',
					'text' => 'Cancel',
				];
				include '../app/views/components/secondaryBtn.php';
				?>
			</div>
		</div>
	</div>
</div> 