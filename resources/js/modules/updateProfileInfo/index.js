import UpdateProfileInfoController from './UpdateProfileInfoController';
import LocaleHelper from '../../helpers/LocaleHelper';

document.addEventListener('DOMContentLoaded', _ => {
    const personalInfoSection = document.querySelector('#personalInfoSection');

    if (personalInfoSection) {
        const controller = new UpdateProfileInfoController({
            form: document.querySelector('#personalInfoSection .personal-info-form'),
            saveButton: document.querySelector('#personalInfoSection .save-personal-info-button'),
            error: document.querySelector('#personalInfoSection .error-message'),
            success: document.querySelector('#personalInfoSection .success-message')
        });
    }

    // Upload profile photo
    const profilePhotoInput = document.querySelector('input[name="profile_picture"]');

    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', e => {
            if (!confirm(LocaleHelper.translate('you-are-sure'))) {
                e.currentTarget.value = '';
                return;
            }

            UpdateProfileInfoController.uploadProfilePhoto(e.currentTarget.files[0]);
        });
    }
});
