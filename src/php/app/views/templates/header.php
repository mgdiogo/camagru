<?php 
	include_once '../app/controllers/UserController.php';
	$user = new UserController;
	$userAvatar = $user->getAvatar($_SESSION['user_id']);
?>
<header>
	<nav class="flex flex-row items-center justify-between h-14 py-2.5 px-4 md:px-8 bg-white relative shadow-[0_4px_4px_0_#0000001A]">
		<a href="/" class="flex">
			<img class="" src="images/logo_black_bg.svg">
		</a>
		<div class="flex flex-row items-center justify-center gap-2.5">
			<div class="flex gap-2.5 pr-2.5">
				<?php
				$props = [
					'text' => 'New Post',
					'icon' => '/images/new_post.svg',
					'href' => '/post',
				];
				include '../app/views/components/primaryBtn.php';
				?>
				<a href="/profile">
					<img class="w-8 h-8 bg-[#D9D9D9] rounded-md hover:opacity-80" src="/uploads/avatars/<?=htmlspecialchars($userAvatar) ?>">
				</a>
			</div>
			<div class="flex h-6 border-l-2 bg-[#E3E3E3]"></div>
			<div class="flex justify-center items-center h-8 md:py-2 md:px-2.5 rounded-md gap-2.5">
				<a href="/logout">
					<img class="w-4 h-4 flex" src="/images/sign_out.svg">
				</a>
			</div>
		</div>
	</nav>
</header>