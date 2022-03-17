class StringHelper {
    static limit(string, limit = 16) {
        if (string.length <= limit) {
            return string;
        }

        return string.slice(0, limit) + '...';
    }
}

export default StringHelper;