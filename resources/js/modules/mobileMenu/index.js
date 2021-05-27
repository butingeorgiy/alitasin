import MobileMenuController from './MobileMenuController';

document.addEventListener('DOMContentLoaded', _ => {
    const burgerIcon = document.querySelector('.burger-menu-icon'),
          mobileMenu = document.querySelector('.mobile-menu');

    alert('Мобильное меню было инициализоровано!');

    if (burgerIcon && mobileMenu) {
        new MobileMenuController({
            burgerIcon,
            mobileMenu
        });
    }
});
