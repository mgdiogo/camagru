document.addEventListener('DOMContentLoaded', (e) => {
	const form = document.getElementById('signupForm');

	const username = document.getElementById('username');
	const email = document.getElementById('email');
	const password = document.getElementById('password');
	const confirmPassword = document.getElementById('confirm_password');

	const usernameError = document.getElementById('usernameError');
	const emailError = document.getElementById('emailError');
	const passwordError = document.getElementById('passwordError');
	const confirmPasswordError = document.getElementById('confirmPasswordError');

	[username, email, password, confirmPassword].forEach(input => {
		input.classList.remove('border-red-600');
	});

	[usernameError, emailError, passwordError, confirmPasswordError].forEach(err => {
		err.classList.add('hidden');
	});

	function validateUsername() {
        const val = username.value.trim().toLowerCase();
        
        if (!val) {
            username.classList.add('border-red-600');
			username.classList.remove('mb-4');
            usernameError.textContent = 'Username is required';
            usernameError.classList.remove('hidden');
            return false;
        } else if (val.length < 4 || val.length > 25) {
            username.classList.add('border-red-600');
			username.classList.remove('mb-4');
            usernameError.textContent = 'Username must have between 4 and 25 characters';
            usernameError.classList.remove('hidden');
            return false;
		} else if (!/[a-zA-Z]/.test(val)) {
			username.classList.add('border-red-600');
			username.classList.remove('mb-4');
			usernameError.textContent = 'Username must contain atleast one letter';
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

	function validateEmail() {
		const val = email.value.trim().toLowerCase();
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

		if (!val) {
			email.classList.add('border-red-600');
			email.classList.remove('mb-4');
			emailError.textContent = 'Email is required';
			emailError.classList.remove('hidden');
			return false;
		} else if (!emailRegex.test(val)) {
			email.classList.add('border-red-600');
			email.classList.remove('mb-4');
			emailError.textContent = 'Please enter a valid email address';
			emailError.classList.remove('hidden');
			return false;
		} else {
			email.classList.remove('border-red-600');
			email.classList.add('mb-4');
			emailError.classList.add('hidden');
			return true;
		}
	}

	email.addEventListener('blur', validateEmail);
	email.addEventListener('input', () => {
		validateEmail();
	});

	function validatePassword() {
		const val = password.value.trim();
		const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@.#$!%*?&])[A-Za-z\d@.#$!%*?&]{8,50}$/;

		if (!val) {
			password.classList.add('border-red-600');
			password.classList.remove('mb-4');
			passwordError.textContent = 'Password is required';
			passwordError.classList.remove('hidden');
			return false;
		} else if (!passwordRegex.test(val)) {
			password.classList.add('border-red-600');
			password.classList.remove('mb-4');
			passwordError.textContent = 'Password is not strong enough';
			passwordError.classList.remove('hidden');
			return false;
		} else {
			password.classList.remove('border-red-600');
			password.classList.add('mb-4');
			passwordError.classList.add('hidden');
			return true;
		}
	}

	password.addEventListener('blur', validatePassword);
	password.addEventListener('input', () => {
		validatePassword();
		if (confirmPassword.value.trim().length > 0)
            validateConfirmPassword();
	});

	function validateConfirmPassword() {
		const val = confirmPassword.value.trim();
		const check = password.value.trim();

		if (!val) {
			confirmPassword.classList.add('border-red-600');
			confirmPassword.classList.remove('mb-6');
			confirmPasswordError.textContent = 'Password is required';
			confirmPasswordError.classList.remove('hidden');
			return false;
		} else if (val !== check) {
			confirmPassword.classList.add('border-red-600');
			confirmPassword.classList.remove('mb-6');
			confirmPasswordError.textContent = 'Password does not match';
			confirmPasswordError.classList.remove('hidden');
			return false;
		} else {
			confirmPassword.classList.remove('border-red-600');
			confirmPassword.classList.add('mb-6');
			confirmPasswordError.classList.add('hidden');
			return true;
		}
	}


	confirmPassword.addEventListener('blur', validateConfirmPassword);
	confirmPassword.addEventListener('input', () => {
		validateConfirmPassword();
	});

	form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const isUsernameValid = validateUsername();
        const isEmailValid = validateEmail();
        const isPasswordValid = validatePassword();
        const isConfirmPasswordValid = validateConfirmPassword();

		if (isUsernameValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
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
					usernameError.textContent = 'Email or username already taken';
					usernameError.classList.remove('hidden');
					email.classList.add('border-red-600');
					email.classList.remove('mb-4');
					emailError.textContent = 'Email or username already taken';
					emailError.classList.remove('hidden');
				}
			} catch (err) {
				console.error('Error: ', err);
			}
		}
	})
})