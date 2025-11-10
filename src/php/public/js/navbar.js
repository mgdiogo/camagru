document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
		menu.classList.toggle('scale-y-0');
   		menu.classList.toggle('scale-y-100');
    });
});