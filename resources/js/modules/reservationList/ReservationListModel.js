class ReservationListModel {
    static async updateStatus(data, reservationId) {
        const url = `${location.origin}/api/reserves/update/${reservationId}/status`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default ReservationListModel;
