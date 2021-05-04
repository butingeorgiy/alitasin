import LanguageSwitcherController from './LanguageSwitcherController';

document.addEventListener('DOMContentLoaded', _ => {
    const languageSwitchSelects = document.querySelectorAll('header select[name="language"]');

    if (languageSwitchSelects.length > 0) {
        languageSwitchSelects.forEach(selectNode => {
            selectNode.addEventListener('change', e => {
                LanguageSwitcherController.change(e.currentTarget.value);
            });
        });
    }
});
