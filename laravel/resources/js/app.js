import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', function () {

    let message = document.querySelector('#message');

    if (message) {
        // Ждем 2 секунды и плавно скрываем сообщение
        setTimeout(function() {
            message.classList.add('opacity-0');
            message.classList.remove('opacity-100');
        }, 2000);

        setTimeout(function() {
            message.remove();
        }, 2500);
    }
});
