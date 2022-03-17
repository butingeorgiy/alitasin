class OrderVehicleModel {
    static async send(id, data) {
        const url = `${location.origin}/api/vehicles/order/${id}`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteVehicle(id) {
        const url = `${location.origin}/api/vehicles/${id}/delete`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async restoreVehicle(id) {
        const url = `${location.origin}/api/vehicles/${id}/restore`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default OrderVehicleModel;
