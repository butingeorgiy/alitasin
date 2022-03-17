class UpdateVehicleModel {
    static async update(id, data) {
        const url = `${location.origin}/api/vehicles/${id}/update`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async setMainImage(vehicleId, data) {
        const url = `${location.origin}/api/vehicles/${vehicleId}/update/change-main-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async deleteImage(vehicleId, data) {
        const url = `${location.origin}/api/vehicles/${vehicleId}/update/remove-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }

    static async uploadImage(vehicleId, data) {
        const url = `${location.origin}/api/vehicles/${vehicleId}/update/upload-image`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default UpdateVehicleModel;