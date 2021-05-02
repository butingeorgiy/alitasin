import FavoritesController from "../modules/favorites/FavoritesController";


class FavoritesTogglingObserver {
    static toggleHandler(button, tourId) {
        const controller = new FavoritesController();

        button.addEventListener('click', e => {
            e.preventDefault();

            if (!controller.loading) {
                controller.loading = true;
                controller.toggleFavorite(button, tourId);
            }
        });
    }
}

export default FavoritesTogglingObserver;
