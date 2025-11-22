<?php
	include_once '../app/controllers/AuthController.php';
	AuthController::validateUser();
	include_once '../app/views/templates/head.php';
?>

<body class="min-h-screen flex flex-col bg-[#F5F5F5]">
	<?php include_once '../app/views/templates/header.php'?>
	<main class="flex p-16 gap-8">
		<?php include '../app/views/components/profileContainer.php'?>
		<?php include '../app/views/components/editProfileContainer.php'?>
		<?php include '../app/views/components/changePasswordContainer.php'?>
	</main>
	<script type="module" src="/js/profile.js"></script>
</body>