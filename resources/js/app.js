import.meta.glob(['../images/**', '../fonts/**']);
import { Fancybox } from '@fancyapps/ui';
import '@fancyapps/ui/dist/fancybox/fancybox.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

Fancybox.bind('[data-fancybox]', {
  // Your custom options here
});

document.addEventListener('DOMContentLoaded', function () {
  const mobileMenuButton = document.querySelector('.mobile-menu-button');
  const mobileMenu = document.querySelector('.nav-primary-mobile');

  mobileMenuButton.addEventListener('click', function () {
    mobileMenu.classList.toggle('-translate-y-[calc(100%+4rem)]');
  });
});
