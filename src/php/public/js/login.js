document.addEventListener('DOMContentLoaded', (e) => {
	const form = document.getElementById('signinForm');

	const username = document.getElementById('username');
	const password = document.getElementById('password');

	const usernameError = document.getElementById('usernameError');
	const passwordError = document.getElementById('passwordError');


	[username, password].forEach(input => {
		input.classList.remove('border-red-600');
	});

	[usernameError, passwordError].forEach(err => {
		err.classList.add('hidden');
	});

	function validateUsername() {
		if (!username.value.trim()) {
			username.classList.add('border-red-600');
			username.classList.remove('mb-4');
			usernameError.textContent = 'Username is required';
			usernameError.classList.remove('hidden');
			return false;
		} else {
            username.classList.remove('border-red-600');
			username.classList.add('mb-4');
            usernameError.classList.add('hidden');
            return true;
        }
	}

	username.addEventListener('blur', validateUsername);
	username.addEventListener('input', () => {
		validateUsername();
	});

	function validatePassword() {
		if (!password.value.trim()) {
			password.classList.add('border-red-600');
			password.classList.remove('mb-6');
			passwordError.textContent = 'Password is required';
			passwordError.classList.remove('hidden');
			return false;
		} else {
			password.classList.remove('border-red-600');
			password.classList.add('mb-6');
			passwordError.classList.add('hidden');
			return true;
		}
	}
	
	password.addEventListener('blur', validatePassword);
	password.addEventListener('input', () => {
		validatePassword();
	});


	form.addEventListener('submit', async (e) => {
		e.preventDefault();

		const userNotEmpty = validateUsername();
		const passNotEmpty = validatePassword();

		if (userNotEmpty && passNotEmpty) {
			try {
				const formData = new FormData(form);
	
				const response = await fetch('/user/login', {
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
					usernameError.textContent = 'Invalid credentials';
					usernameError.classList.remove('hidden');
				}
			} catch (err) {
				console.error('Error: ', err);
			}
		}
	})
})