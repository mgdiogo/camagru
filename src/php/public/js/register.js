document.addEventListener('DOMContentLoaded', (e) => {
	const form = document.getElementById('signupForm');

	const fields = {
		username: {
			input: document.getElementById('username'),
			error: document.getElementById('usernameError'),
			marginClass: 'mb-4',
			validators: [
				{ check: val => !!val, msg: 'Username is required' },
				{ check: val => val.length >= 4 && val.length <= 25, msg: 'Username must have between 4 and 25 characters' },
				{ check: val => /[a-zA-Z]/.test(val), msg: 'Username must contain atleast one letter' }
			]
		},
		email: {
			input: document.getElementById('email'),
			error: document.getElementById('emailError'),
			marginClass: 'mb-4',
			validators: [
				{ check: val => !!val, msg: 'Email is required' },
				{ check: val => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val), msg: 'Please enter a valid email address' }
			]
		},
		password: {
			input: document.getElementById('password'),
			error: document.getElementById('passwordError'),
			marginClass: 'mb-4',
			validators: [
				{ check: val => !!val, msg: 'Password is required' },
				{ check: val => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&]).{8,50}$/.test(val), msg: 'Password is not strong enough' }
			]
		},
		confirmPassword: {
			input: document.getElementById('confirm_password'),
			error: document.getElementById('confirmPasswordError'),
			marginClass: 'mb-6',
			validators: [
				{ check: val => !!val, msg: 'Password is required' },
				{ check: val => val === document.getElementById('password').value, msg: 'Password does not match' }
			]
		}
	}

	const errorBorder = 'border-[#ed834e]';

	function showError(field, msg) {
		field.input.classList.add(errorBorder);
		field.input.classList.remove(field.marginClass);
		field.error.textContent = msg;
		field.error.classList.remove('hidden');
	}

	function hideError(field) {
		field.input.classList.remove(errorBorder);
		field.input.classList.add(field.marginClass);
		field.error.classList.add('hidden');
	}

	function validateField(field) {
		const val = field.input.value.trim();
		for (let rule of field.validators) {
			if (!rule.check(val)) {
				showError(field, rule.msg);
				return false;
			}
		}
		hideError(field);
		return true;
	}

	Object.values(fields).forEach(field => {
		field.input.addEventListener('blur', () => validateField(field));
		field.input.addEventListener('input', () => validateField(field));
	});

	fields.password.input.addEventListener('input', () => validateField(fields.confirmPassword));

	form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
		let allValid = true;
		Object.values(fields).forEach(field => {
			if (!validateField(field)) allValid = false;
		});

		if (!allValid) return;

		try {
			const formData = new FormData(form);

			const response = await fetch('/user/register', {
				method: 'POST',
				body: formData
			})

			const result = await response.json();
			
			if (result.success) {
				if (result.redirect) {
					setTimeout(() => {
						window.location.href = result.redirect;
					})
				}
			} else {
				username.classList.add('border-red-600');
				username.classList.remove('mb-4');
				usernameError.textContent = result.message;
				usernameError.classList.remove('hidden');
			}
		} catch (err) {
			console.error('Error: ', err);
		}
	})
})