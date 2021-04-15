import langConfig from '../config/lang';

class LocaleHelper {
    static getLocale() {
        return document.documentElement.getAttribute('lang');
    }

    static translate(key) {
        if (!langConfig.dictionary[key]) {
            return null;
        }

        if (!langConfig.dictionary[key][LocaleHelper.getLocale()]) {
            return null;
        }

        return langConfig.dictionary[key][LocaleHelper.getLocale()];
    }
}

export default LocaleHelper;
