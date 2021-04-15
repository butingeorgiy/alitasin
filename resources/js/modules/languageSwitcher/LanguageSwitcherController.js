import EventHandler from '../../core/EventHandler';
import Cookies from 'js-cookie';

class LanguageSwitcherController extends EventHandler {
    static change(lang) {
        Cookies.set('locale', lang, { expires: 30 });
        location.reload();
    }
}

export default LanguageSwitcherController;
