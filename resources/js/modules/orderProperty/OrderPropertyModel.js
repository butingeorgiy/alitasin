class OrderPropertyModel {
    static async order(id, data) {
        const url = `${location.origin}/api/properties/${id}/order`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default OrderPropertyModel;