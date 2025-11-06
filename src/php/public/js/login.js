document.addEventListener('DOMContentLoaded', (e) => {
	const form = document.getElementById('signinForm');

	const fields = {
		username: {
			input: document.getElementById('username'),
			error: document.getElementById('usernameError'),
			requiredMsg: 'Username is required',
			marginClass: 'mb-4'
		},
		password: {
			input: document.getElementById('password'),
			error: document.getElementById('passwordError'),
			requiredMsg: 'Password is required',
			marginClass: 'mb-6'
		}
	};

	const errorBorder = 'border-[#ed834e]';

	function showError(field, message) {
		field.input.classList.add(errorBorder);
		field.input.classList.remove(field.marginClass);
		field.error.textContent = message;
		field.error.classList.remove('hidden');
	}

	function hideError(field) {
		field.input.classList.remove(errorBorder);
		field.input.classList.add(field.marginClass);
		field.error.classList.add('hidden');
	}

	function validateField(field) {
		if (!field.input.value.trim()) {
			showError(field, field.requiredMsg);
			return false;
		} else {
			hideError(field);
			return true;
		}
	}

	Object.values(fields).forEach(field => {
		field.input.addEventListener('blur', () => validateField(field));
		field.input.addEventListener('input', () => validateField(field));
	});

	form.addEventListener('submit', async (e) => {
		e.preventDefault();

		let allValid = true;
		Object.values(fields).forEach(field => {
			if (!validateField(field)) allValid = false;
		});

		if (!allValid) return;

		try {
			const formData = new FormData(form);

			const response = await fetch('/auth/login', {
				method: 'POST',
				body: formData,
				credentials: 'include'
			})

			const result = await response.json();

			if (result.success) {
				if (result.redirect) {
					setTimeout(() => {
						window.location.href = result.redirect;
					})
				}
				return;
			} else if (!result.verified) {
				showError(fields.username, result.message);
				return;
			}
			showError(fields.username, result.message);
		} catch (err) {
			console.error('Error: ', err);
		}
	})
})