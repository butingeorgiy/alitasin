class UpdatePropertyModel {
    static async update(id, data) {
        const url = `${location.origin}/api/properties/${id}/update`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async setMainImage(vehicleId, data) {
        const url = `${location.origin}/api/properties/${vehicleId}/update/change-main-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteImage(vehicleId, data) {
        const url = `${location.origin}/api/properties/${vehicleId}/update/remove-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async uploadImage(vehicleId, data) {
        const url = `${location.origin}/api/properties/${vehicleId}/update/upload-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async restore(id) {
        const url = `${location.origin}/api/properties/${id}/restore`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async delete(id) {
        const url = `${location.origin}/api/properties/${id}/delete`;

        const response = await fetch(url, {
            method: 'POST'
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default UpdatePropertyModel;