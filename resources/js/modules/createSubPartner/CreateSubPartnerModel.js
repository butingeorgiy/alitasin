class CreateSubPartnerModel {
    static async send(data) {
        const url = `${location.origin}/api/partners/create-sub-partner`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default CreateSubPartnerModel;