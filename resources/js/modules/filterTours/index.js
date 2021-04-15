import FilterToursController from './FilterToursController';

document.addEventListener('DOMContentLoaded', _ => {
    const toursSection = document.querySelector('#toursSection');

    if (toursSection) {
        new FilterToursController({
            filterButtons: document.querySelectorAll('#toursSection .filter-item'),
            typeButtons: document.querySelectorAll('#toursSection .type-items'),
            minPriceInput: document.querySelector('#toursSection input[name="price_from"]'),
            maxPriceInput: document.querySelector('#toursSection input[name="price_to"]'),
            toursContainer: document.querySelector('#toursSection .tours-container'),
            resetFiltersButton: document.querySelector('#toursSection .reset-filters-button'),
            filtersContainer: document.querySelector('#toursSection .filters'),
            showMoreButton: document.querySelector('#toursSection .show-more-tours-button')
        });
    }
});
