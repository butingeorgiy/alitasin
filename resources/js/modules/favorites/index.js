import FavoritesController from './FavoritesController';

document.addEventListener('DOMContentLoaded', _ => {
    if (/^\/|\/region\/\d+$/.test(location.pathname) || location.pathname === '') {
        const toggleFavoriteButtons = document.querySelectorAll('.toggle-favorite-button');

        new FavoritesController({
            toggleFavoriteButtons
        });
    }
});
