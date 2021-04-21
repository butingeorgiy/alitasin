class BookTourModel {
    static async getPromoCodeSale(code) {
        const url = `${location.origin}/api/promo-codes/check?code=${code}`;

        const response = await fetch(url);

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async reserve(data, tourId) {
        const url = `${location.origin}/api/tours/reserve/${tourId}`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default BookTourModel;
