import LanguageSwitcherController from './LanguageSwitcherController';

document.addEventListener('DOMContentLoaded', _ => {
    const languageSwitchSelect = document.querySelector('header select[name="language"]');

    if (languageSwitchSelect) {
        languageSwitchSelect.addEventListener('change', e => {
            LanguageSwitcherController.change(e.currentTarget.value);
        });
    }
});
