class FavoritesModel {
    static async toggle(tourId) {
        const url = `${location.origin}/api/tours/toggle-favorite/${tourId}`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default FavoritesModel;
