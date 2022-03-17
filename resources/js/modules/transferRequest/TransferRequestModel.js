class TransferRequestModel {
    static async send(data) {
        const url = `${location.origin}/api/transfers/requests/create`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async checkPromoCode(promoCode) {
        const response = await fetch(`${location.origin}/api/promo-codes/check?code=${promoCode}`);

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default TransferRequestModel;