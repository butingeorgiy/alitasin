class ManageTransfersModel {
    static async deleteAirport(id) {
        const url = `${location.origin}/api/airports/${id}/delete`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteDestination(id) {
        const url = `${location.origin}/api/destinations/${id}/delete`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async restoreAirport(id) {
        const url = `${location.origin}/api/airports/${id}/restore`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async restoreDestination(id) {
        const url = `${location.origin}/api/destinations/${id}/restore`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default ManageTransfersModel;