class JsonHelper {
    static parse(json) {
        try {
            return JSON.parse(json);
        } catch (_) {
            return null;
        }
    }

    static getFromJson(json, ...keys) {
        let parsedJson = JsonHelper.parse(json), output = [];

        if (parsedJson === null) {
            for (let i = 0; i < arguments.length - 1; i++) {
                output.push(null);
            }

            return output;
        }

        [...arguments].forEach((value, index) => {
            if (index !== 0) {
                output.push(parsedJson[value] ? parsedJson[value] : null);
            }
        });

        return output;
    }
}

export default JsonHelper;
