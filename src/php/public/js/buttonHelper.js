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