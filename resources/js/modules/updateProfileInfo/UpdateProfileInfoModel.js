class UpdateProfileInfoModel {
    static async uploadImage(data) {
        const url = `${location.origin}/api/users/update/profile-photo`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : response.text();
    }

    static async update(data) {
        const url = `${location.origin}/api/users/update`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : response.text();
    }
}

export default UpdateProfileInfoModel;
