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