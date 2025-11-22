import { setPrimaryButtonState, clearField, validateField, checkEmptyFields } from './helperFunctions.js'

 export function editProfile(document) {
	const editBtn = document.getElementById('edit_btn');
	const sendEditBtn = document.getElementById('send_edit_btn');
	const editModal = document.getElementById('edit_modal');
	const cancelEditProfile = document.getElementById('cancel_edit_profile');
	const avatar = document.getElementById('user_avatar');
	const avatarUpload = document.getElementById('avatar');
	const originalAvatar = avatar.src;
	const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

	setPrimaryButtonState(sendEditBtn, 'disabled');

	const editForm = document.getElementById('editProfileForm');

	const editFormFields = {
		username: {
			input: document.getElementById('username'),
			error: document.getElementById('usernameError'),
			validators: [
				{ check: val => val.length >= 4 && val.length <= 25, msg: 'Username must have between 4 and 25 characters' },
				{ check: val => /[a-zA-Z]/.test(val), msg: 'Username must contain atleast one letter' }
			]
		},
		email: {
			input: document.getElementById('email'),
			error: document.getElementById('emailError'),
			validators: [
				{ check: val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val), msg: 'Please enter a valid email address' }
			]
		}
	};

	editBtn.addEventListener('click', () => {
		editModal.classList.remove('hidden');
	});

	editModal.addEventListener('click', (e) => {
		if (!(document.getElementById('edit_profile').contains(e.target))) {
			editModal.classList.add('hidden');
			clearField(editFormFields.username.input, editFormFields.username.error);
			clearField(editFormFields.email.input, editFormFields.email.error);
			clearField(avatar, avatarError);
			avatar.src = originalAvatar;
		}
	});

	cancelEditProfile.addEventListener('click', () => {
		editModal.classList.add('hidden');
		clearField(editFormFields.username.input, editFormFields.username.error);
		clearField(editFormFields.email.input, editFormFields.email.error);
		clearField(avatar, avatarError);
		avatar.src = originalAvatar;
	});

	function showErrorAvatar(field, msg) {
		field.textContent = msg;
		field.classList.remove('hidden');
	}

	avatarUpload.addEventListener('change', (e) => {
		const file = e.target.files[0];

		if (!file) {
			showErrorAvatar(avatarError, 'Please select a file');
			return false;
		}

		if (!allowedExtensions.exec(file.name)) {
			showErrorAvatar(avatarError, 'File extension not supported');
			avatarUpload.value = '';
			return false;
		}

		const imgUrl = URL.createObjectURL(file);
		avatar.src = imgUrl;

		avatar.onload = () => {
			URL.revokeObjectURL(imgUrl);
		};

		setPrimaryButtonState(sendEditBtn, 'primary');
	})

	Object.values(editFormFields).forEach(field => {
		field.input.addEventListener('input', () => checkEmptyFields(field, editFormFields, sendEditBtn, 'edit'));
	});

	editForm.addEventListener('submit', async (e) => {
		e.preventDefault();

		let allValid = true;
		Object.values(editFormFields).forEach(field => {
			if (field.input.value.trim() !== '') {
				if (!validateField(field)) allValid = false;
			}
		});

		if (!allValid) return;

		try {
			const editFormData = new FormData(editForm);

			const response = await fetch('/profile/edit', {
				method: 'POST',
				body: editFormData,
				credentials: 'include'
			});

			const contentType = response.headers.get('content-type') || '';

			let result;

			try {
				if (contentType.includes('application/json'))
					result = await response.json();
			} catch (err) {
				console.error('Unexpected server error [updating profile]: ', err);
			}

			if (result) {
				if (result.success && result.redirect) {
					setTimeout(() => {
						window.location.href = result.redirect;
					})
				} else {
					emailError.classList.remove('hidden');
					emailError.textContent = result.message;
				}
			} else if (response.status === 413) {
				avatarError.classList.remove('hidden');
				avatarError.textContent = 'Image must not be larger than 2MB';
				return;
			} else {
				setTimeout(() => {
					window.location.href = '/profile';
				})
			}
		} catch (err) {
			console.error('Error updating user info: ', err);
		}
	});
}