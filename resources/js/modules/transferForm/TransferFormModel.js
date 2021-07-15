class TransferFormModel {
    static async getAirports() {
        const response = await fetch(`${location.origin}/api/transfers/airports`);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async getDestinations() {
        const response = await fetch(`${location.origin}/api/transfers/destinations`);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async calculate(query) {
        const response = await fetch(`${location.origin}/api/transfers/calculate${query}`);

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default TransferFormModel;