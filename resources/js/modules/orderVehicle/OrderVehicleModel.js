class OrderVehicleModel {
    static async send(id, data) {
        const url = `${location.origin}/api/vehicles/order/${id}`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default OrderVehicleModel;
