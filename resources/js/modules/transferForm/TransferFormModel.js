class TransferFormModel {
    static async getAirports(withTrashed = false) {
        const response = await fetch(`${location.origin}/api/airports?with_deleted=${withTrashed ? '1' : '0'}`);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async getDestinations(withTrashed = false) {
        const response = await fetch(`${location.origin}/api/destinations?with_deleted=${withTrashed ? '1' : '0'}`);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async calculate(query) {
        const response = await fetch(`${location.origin}/api/transfers/calculate${query}`);

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default TransferFormModel;