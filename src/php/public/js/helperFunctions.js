const errorBorder = 'border-[#AA1616]';
const border = 'border-[#A6A6A6]';

export function setPrimaryButtonState(btn, state = 'primary') {
    btn.disabled = state !== 'primary';

	btn.classList.remove('opacity-60');

    switch(state) {
        case 'primary':
            btn.classList.add('bg-[#E85105]', 'hover:opacity-80');
            break;
        case 'disabled':
            btn.classList.add('opacity-60');
			btn.classList.remove('hover:opacity-80');
            break;
    }
}

export function clearField(field, error) {
	field.value = '';
	field.classList.remove(errorBorder);
	field.classList.add(border);
	error.classList.add('hidden');
}

export function checkEmptyFields(field, formFields, btn, form = 'edit') {
	let filled;

	if (form === 'edit') {
		filled = Object.values(formFields).some(field => field.input.value.trim() !== '');
	
		if (!filled) {
			setPrimaryButtonState(btn, 'disabled');
			return;
		}
		setPrimaryButtonState(btn, 'primary');
		return;
	}

	filled = Object.values(formFields).every(field => field.input.value.trim() !== '');
	
		if (!filled) {
			setPrimaryButtonState(btn, 'disabled');
			return;
		}
		setPrimaryButtonState(btn, 'primary');
		return;
}

export function showError(field, msg) {
	field.input.classList.remove(border);
	field.input.classList.add(errorBorder);
	field.error.textContent = msg;
	field.error.classList.remove('hidden');
}

export function hideError(field) {
	field.input.classList.add(border);
	field.input.classList.remove(errorBorder);
	field.error.classList.add('hidden');
}

export function validateField(field) {
	const value = field.input.value.trim();

	if (!field.validators || field.validators.length === 0) {
        hideError(field);
        return true;
    }

    for (const rule of field.validators) {
        if (!rule.check(value)) {
            showError(field, rule.msg);
            return false;
        }
    }

	hideError(field);
	return true;
}