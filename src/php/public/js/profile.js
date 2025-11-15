document.addEventListener('DOMContentLoaded', (e) => {
	const editBtn = document.getElementById('edit_btn');
	const sendEditBtn = document.getElementById('send_edit_btn');
	const editModal = document.getElementById('edit_profile');
	const cancelEditProfile = document.getElementById('cancel_edit_profile')
	const changePasswordBtn = document.getElementById('password_btn');
	const deleteAccountBtn = document.getElementById('delete_btn');

	function clearField(field, error) {
		field.value = '';
		error.classList.add('hidden');
	}

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
		if (!(document.getElementById('edit_modal').contains(e.target))) {
			editModal.classList.add('hidden');
			clearField(editFormFields.username.input, editFormFields.username.error);
			clearField(editFormFields.email.input, editFormFields.email.error);
		}
	});

	cancelEditProfile.addEventListener('click', () => {
		editModal.classList.add('hidden');
		clearField(editFormFields.username.input, editFormFields.username.error);
		clearField(editFormFields.email.input, editFormFields.email.error);
	});

	errorBorder = 'border-#FFEAEA'

	function checkEmptyFields(field) {
		const filled = Object.values(editFormFields).some(field => field.input.value.trim() !== '');

		if (!filled) {
			sendEditBtn.disabled = true;
			sendEditBtn.classList.add('bg-[#444444]');
			sendEditBtn.classList.remove('bg-black')
			return;
		}
		sendEditBtn.disabled = false;
		sendEditBtn.classList.add('bg-black');
		sendEditBtn.classList.remove('bg-[#444444]')
	}

	function showError(field, msg) {
		field.input.classList.add(errorBorder);
		field.error.textContent = msg;
		field.error.classList.remove('hidden');
	}

	function hideError(field) {
		field.input.classList.remove(errorBorder);
		field.error.classList.add('hidden');
	}

	function validateField(field) {
		const value = field.input.value.trim();
	
		for (const rule of field.validators) {
			if (!rule.check(value)) {
				showError(field, rule.msg);
				return false;
			} else {
				hideError(field);
				return true;
			}
		}
	}

	Object.values(editFormFields).forEach(field => {
		field.input.addEventListener('focus', () => checkEmptyFields(field));
		field.input.addEventListener('blur', () => checkEmptyFields(field));
		field.input.addEventListener('input', () => checkEmptyFields(field));
	});

	Object.values(editFormFields).forEach(field => {
		field.input.addEventListener('submit', () => validateField(field));
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

			const result = await response.json();

			if (result.success && result.redirect) {
				setTimeout(() => {
					window.location.href = result.redirect;
				})
			} else {
				emailError.classList.remove('hidden');
				emailError.textContent = result.message;
			}
		} catch (err) {
			console.error('Error updating user info: ', err);
		}
	});
})