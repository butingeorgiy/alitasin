import EventHandler from '../../core/EventHandler';
import UpdateProfileInfoModel from './UpdateProfileInfoModel';
import LocaleHelper from '../../helpers/LocaleHelper';
import UpdateProfileInfoView from './UpdateProfileInfoView';
import Cookies from 'js-cookie';

class UpdateProfileInfoController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;
        this.hasChanges = false;
        this.initValues = null;
        this.view = new UpdateProfileInfoView({
            btn: nodes.saveButton,
            error: nodes.error,
            success: nodes.success
        });

        this.getValues(true);
        this.initChangeInputsHandlers();
        this.addEvent(nodes.saveButton, 'click', _ => {
            if (!this.loading && this.hasChanges) {
                this.update();
            }
        });
    }

    getValues(init = false) {
        let values = {
            firstName: this.nodes.form.querySelector('input[name="first_name"]').value,
            lastName: this.nodes.form.querySelector('input[name="last_name"]').value,
            phone: this.nodes.form.querySelector('input[name="phone"]').value.replace(/\D/g, ''),
            email: this.nodes.form.querySelector('input[name="email"]').value,
            new_password: this.nodes.form.querySelector('input[name="new_password"]').value,
            new_password_confirmation: this.nodes.form.querySelector('input[name="new_password_confirmation"]').value
        };

        if (init && this.initValues === null) {
            this.initValues = values;
            return null;
        }

        return values;
    }

    initChangeInputsHandlers() {
        const changeHandler = _ => {
            if (JSON.stringify(this.initValues) !== JSON.stringify(this.getValues())) {
                this.view.enableButton();
                this.hasChanges = true;
            } else {
                this.view.disableButton();
                this.hasChanges = false;
            }
        }

        this.addEvent(this.nodes.form.querySelector('input[name="first_name"]'), 'input', changeHandler);
        this.addEvent(this.nodes.form.querySelector('input[name="last_name"]'), 'input', changeHandler);
        this.addEvent(this.nodes.form.querySelector('input[name="email"]'), 'input', changeHandler);
        this.addEvent(this.nodes.form.querySelector('input[name="phone"]'), 'input', changeHandler);
        this.addEvent(this.nodes.form.querySelector('input[name="new_password"]'), 'input', changeHandler);
        this.addEvent(this.nodes.form.querySelector('input[name="new_password_confirmation"]'), 'input', changeHandler);
    }

    static uploadProfilePhoto(file) {
        const formData = new FormData();

        formData.append('profile_photo', file);

        UpdateProfileInfoModel.uploadImage(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(LocaleHelper.translate('file-uploading-success'));
                    location.reload();
                }
            })
            .catch(error => `Error: ${error}`);
    }

    update() {
        this.loading = true;
        this.view.hideError();
        this.view.showLoading();

        const values = this.getValues();
        const formData = new FormData();

        let mode = 'user', options = {};

        formData.append('first_name', values.firstName);
        formData.append('email', values.email);
        formData.append('phone', values.phone);

        if (values.lastName) {
            formData.append('last_name', values.lastName);
        }

        if (values.new_password) {
            formData.append('new_password', values.new_password);
            formData.append('new_password_confirmation', values.new_password_confirmation);
        }

        if (/admin\/partners\/\d+/.test(location.pathname)) {
            mode = 'partner';
            options = {
                id: location.pathname.split('/')[3]
            };
        }

        UpdateProfileInfoModel.update(formData, mode, options)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showError(result.message);
                } else {
                    this.view.removeButton();
                    this.view.showSuccess(result.message);
                    this.hasChanges = false;

                    if (result['cookies']?.token) {
                        Cookies.set('token', result['cookies']['token'], { expires: 7 });
                    }

                    setTimeout(_ => location.reload(), 500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
                this.view.hideLoading();
            });
    }
}

export default UpdateProfileInfoController;
