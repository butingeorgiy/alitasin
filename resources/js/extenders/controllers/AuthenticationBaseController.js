import EventHandler from '../../core/EventHandler';
import Cookies from 'js-cookie';

class AuthenticationBaseController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;

        this.initPopup();
    }

    showForm() {
        this.popup.open();
    }

    setAuthCookie(cookies) {
        Cookies.set('id', cookies.id, { expires: 7 });
        Cookies.set('token', cookies.token, { expires: 7 });
    }
}

export default AuthenticationBaseController;
