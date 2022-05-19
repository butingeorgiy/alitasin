class PartnerRegistrationModel {
    static async send(data) {
        const url = `${location.origin}/api/partners/register`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default PartnerRegistrationModel;