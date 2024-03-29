class CreateDestinationModel {
    static async create(data) {
        const url = `${location.origin}/api/destinations/create`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default CreateDestinationModel;