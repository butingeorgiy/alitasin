class ManageTransferVariationsModel {
    static async updateVariation(data, transferId) {
        const url = `${location.origin}/api/transfers/${transferId}/update-cost`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteVariation(data, transferId) {
        const url = `${location.origin}/api/transfers/${transferId}/delete-cost`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async checkTransfer(airportId, destinationId) {
        const url = `${location.origin}/api/transfers/check?airport_id=${airportId}&destination_id=${destinationId}`;

        const response = await fetch(url);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async getAvailableVariations(airportId, destinationId) {
        const url = `${location.origin}/api/transfers/variations?airport_id=${airportId}&destination_id=${destinationId}`;

        const response = await fetch(url);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async createTransfer(data) {
        const url = `${location.origin}/api/transfers/create`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteTransfer(transferId) {
        const url = `${location.origin}/api/transfers/${transferId}/delete`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default ManageTransferVariationsModel;