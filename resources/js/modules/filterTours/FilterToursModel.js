class FilterToursModel {
    static async search(uri) {
        const url = `${location.origin}/api/tours${uri}`;

        const response = await fetch(url);

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default FilterToursModel;
