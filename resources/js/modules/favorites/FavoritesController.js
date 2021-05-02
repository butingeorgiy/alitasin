import EventHandler from '../../core/EventHandler';
import FavoritesModel from './FavoritesModel';
import FavoritesView from "./FavoritesView";

class FavoritesController extends EventHandler {
    constructor(nodes = null) {
        super();

        if (FavoritesController._instance) {
            return this;
        } else {
            this.loading = false;

            nodes.toggleFavoriteButtons.forEach(node => {
                this.addEvent(node, 'click', e => {
                    e.preventDefault();

                    if (!this.loading) {
                        this.toggleFavorite(node, node.getAttribute('data-tour-id'));
                    }
                });
            });

            FavoritesController._instance = this;
        }
    }

    toggleFavorite(button, tourId) {
        this.loading = true;

        FavoritesModel.toggle(tourId)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
                } else {
                    FavoritesView.toggleIcon(button);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false
            });
    }
}

export default FavoritesController;
