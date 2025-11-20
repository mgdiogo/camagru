document.addEventListener('DOMContentLoaded', (e) => {
	const avatar = document.getElementById('user_avatar');
	const avatarUpload = document.getElementById('avatar');
	const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;


	avatarUpload.addEventListener('change', (e) => {
		const file = e.target.files[0];

		if (!allowedExtensions.exec(file.name)) {
			alert('Invalid file type');
			avatarUpload.value = '';
			return false;
		}

		if (!file) return;
		const imgUrl = URL.createObjectURL(file);
		avatar.src = imgUrl;

		avatar.onload = () => {
            URL.revokeObjectURL(imgUrl);
        };
	});
})