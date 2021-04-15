class UpdateTourModel {
    static async update(tourId, data) {
        const url = `${location.origin}/api/tours/update/${tourId}`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async uploadImage(tourId, data) {
        const url = `${location.origin}/api/tours/update/${tourId}/upload-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async removeImage(tourId, data) {
        const url = `${location.origin}/api/tours/update/${tourId}/remove-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async setMainImage(tourId, data) {
        const url = `${location.origin}/api/tours/update/${tourId}/change-main-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default UpdateTourModel;
