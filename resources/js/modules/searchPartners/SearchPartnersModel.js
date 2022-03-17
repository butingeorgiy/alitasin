class SearchPartnersModel {
    static async search(query) {
        const response = await fetch(`${location.origin}/api/partners/search?query=${query}`);

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default SearchPartnersModel;