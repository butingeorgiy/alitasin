import LocaleHelper from '../../helpers/LocaleHelper';
import StringHelper from '../../helpers/StringHelper';

class SearchPartnersView {
    constructor(nodes) {
        this.loaderIcon = nodes.loaderIcon;
        this.resultsContainer = nodes.resultsContainer;
    }

    showLoading() {
        this.loaderIcon.classList.remove('hidden');
    }

    hideLoading() {
        this.loaderIcon.classList.add('hidden');
    }

    getResultItem(id, name, promoCode) {
        return `
            <div class="flex items-center pl-3 pr-6 py-3 border-b last:border-0 border-gray-200">
                <div class="min-w-9 min-h-9 w-9 h-9 mr-5 bg-contain bg-center bg-no-repeat bg-blue rounded-full"></div>
                <div class="w-1/3 mr-4 text-black font-semibold leading-5">${name}</div>
                <div class="mr-auto text-gray-600 font-light" title="${promoCode}">${StringHelper.limit(promoCode, 14)}</div>
                <a href="/admin/partners/${id}" 
                   class="text-sm text-blue font-semibold cursor-pointer whitespace-nowrap hover:underline">
                   ${LocaleHelper.translate('go-to')}</a>
            </div>
        `;
    }

    renderResults(results) {
        results.forEach(item => {
            this.resultsContainer.innerHTML += this.getResultItem(item['id'], item['name'], item['promo_code']);
        });
    }

    clearResultsContainer() {
        this.resultsContainer.innerHTML = '';
    }

    showEmptyMessage() {
        this.resultsContainer.innerHTML = `
            <div class="p-3 text-gray-500">${LocaleHelper.translate('no-results')}</div>
        `;
    }

    showResultsContainer() {
        this.resultsContainer.classList.remove('hidden');
    }

    hideResultsContainer() {
        this.resultsContainer.classList.add('hidden');
    }

    isResultContainerVisible() {
        return !this.resultsContainer.classList.contains('hidden');
    }
}

export default SearchPartnersView;