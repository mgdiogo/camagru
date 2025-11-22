import { setPrimaryButtonState, clearField, validateField, checkEmptyFields } from './helperFunctions.js'

export function changePassword(document) {
	const changePasswordBtn = document.getElementById('password_btn');
	const savePasswordBtn = document.getElementById('change_password_btn');
	const passwordModal = document.getElementById('change_password_modal');
	const cancelBtn = document.getElementById('cancel_btn');

	setPrimaryButtonState(savePasswordBtn, 'disabled');

	changePasswordBtn.addEventListener('click', () => {
		passwordModal.classList.remove('hidden');
	});

	const changePasswordForm = document.getElementById('changePasswordForm');

	passwordModal.addEventListener('click', (e) => {
		if (!(document.getElementById('change_password').contains(e.target))) {
			passwordModal.classList.add('hidden');
			//clearField(editFormFields.username.input, editFormFields.username.error);
			//clearField(editFormFields.email.input, editFormFields.email.error);
		}
	});

	cancelBtn.addEventListener('click', (e) => {
		passwordModal.classList.add('hidden');
		//clearField
		//clearField
	});

	const changePasswordFormFields = {
		currentPassword: {
			input: document.getElementById('current_pw'),
			error: document.getElementById('passwordError'),
			validators: []
		},
		newPassword: {
			input: document.getElementById('new_pw'),
			error: document.getElementById('newPasswordError'),
			validators: [
				{ check: val => !!val, msg: 'Password is required' },
				{ check: val => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&]).{8,50}$/.test(val), msg: 'Password is not strong enough' }
			]
		},
		confirmPassword: {
			input: document.getElementById('confirm_pw'),
			error: document.getElementById('confirmPasswordError'),
			validators: [
				{ check: val => !!val, msg: 'Password is required' },
				{ check: val => val === document.getElementById('new_pw').value, msg: 'Password does not match' }
			]
		}
	};

	Object.values(changePasswordFormFields).forEach(field => {
		field.input.addEventListener('input', () => checkEmptyFields(field, changePasswordFormFields, savePasswordBtn, 'password'));
	});

	changePasswordForm.addEventListener('submit', async (e) => {
		e.preventDefault();

		let allValid = true;
		Object.values(changePasswordFormFields).forEach(field => {
			if (field.input.value.trim() !== '') {
				if (!validateField(field)) allValid = false;
			}
		});

		if (!allValid) return;

		try {
			const passwordFormData = new FormData(changePasswordForm);

			const response = await fetch('/profile/edit/password', {
				method: 'POST',
				body: passwordFormData,
				credentials: 'include'
			});

			let result = {};

			try {
				result = await response.json();
			} catch (err) {
				console.error('Unexpected server error [changing password]: ', err);
			}

			if (result.success && result.redirect) {
				setTimeout(() => {
					window.location.href = result.redirect;
				})
			} else if (result.field === 'currentPassword') {
				changePasswordFormFields.currentPassword.input.classList.remove('border-[#A6A6A6]');
				changePasswordFormFields.currentPassword.input.classList.add('border-[#AA1616]');
				changePasswordFormFields.currentPassword.error.textContent = result.message;
				changePasswordFormFields.currentPassword.error.classList.remove('hidden');
			} else {
				changePasswordFormFields.newPassword.input.classList.remove('border-[#A6A6A6]');
				changePasswordFormFields.newPassword.input.classList.add('border-[#AA1616]');
				changePasswordFormFields.newPassword.error.textContent = result.message;
				changePasswordFormFields.newPassword.error.classList.remove('hidden');
			}
			
		} catch (err) {
			console.error('Error updating user password: ', err);
		}
	})
}