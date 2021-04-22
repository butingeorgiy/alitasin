class RegistrationModel {
    static async reg(data) {
        const url = `${location.origin}/api/auth/reg`;

        const response = await fetch(url, {
            method: 'POST',
            body: data
        });

        return response.status === 200 ? await response.json() : await response.text();
    }
}

export default RegistrationModel;
