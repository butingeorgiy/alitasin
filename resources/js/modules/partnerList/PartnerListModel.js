class PartnerListModel {
    static async delete(id) {
        const url = `${location.origin}/api/partners/delete/${id}`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async restore(id) {
        const url = `${location.origin}/api/partners/restore/${id}`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async makePayment(data, id) {
        const url = `${location.origin}/api/partners/make-payment/${id}`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default PartnerListModel;
