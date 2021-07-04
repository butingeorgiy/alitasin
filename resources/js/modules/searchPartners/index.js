import SearchPartnersController from './SearchPartnersController';

document.addEventListener('DOMContentLoaded', _ => {
    const partnersSearchWrapper = document.querySelector('.partners-search-wrapper');

    if (partnersSearchWrapper) {
        new SearchPartnersController({
            input: partnersSearchWrapper.querySelector('input[name="search"]'),
            resultsContainer: partnersSearchWrapper.querySelector('.partners-search-results-container'),
            loaderIcon: partnersSearchWrapper.querySelector('.animate-spin')
        });
    }
});