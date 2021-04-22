class FilterToursModel {
    static async search(uri) {
        const url = `${location.origin}/api/tours${uri}`;

        const response = await fetch(url);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async delete(tourId) {
        const url = `${location.origin}/api/tours/delete/${tourId}`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default FilterToursModel;
