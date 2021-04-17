import LocaleHelper from '../../helpers/LocaleHelper';

class FilterToursView {
    constructor(nodes) {
        this.toursContainer = nodes.toursContainer;
        this.resetFiltersButton = nodes.resetFiltersButton;
        this.filtersContainer = nodes.filtersContainer;
        this.showMoreButton = nodes.showMoreButton;
    }

    toggleFiltersForm(btn) {
        if (document.body.clientWidth < 1024) {
            if (this.filtersContainer.parentElement.classList.contains('hidden')) {
                this.filtersContainer.parentElement.classList.remove('hidden');
                btn.innerText = LocaleHelper.translate('close');
            } else {
                this.filtersContainer.parentElement.classList.add('hidden');
                btn.innerText = LocaleHelper.translate('filters');
            }
        }
    }

    clearContainer() {
        this.toursContainer.innerHTML = '';
    }

    static tabActiveToggle(node) {
        node.classList.toggle('active');
    }

    resetFiltersForm() {
        this.filtersContainer.querySelectorAll('.filter-item').forEach(node => node.classList.remove('active'));
        this.filtersContainer.querySelectorAll('.type-items').forEach(node => node.classList.remove('active'));
        this.filtersContainer.querySelector('input[name="price_from"]').value = '';
        this.filtersContainer.querySelector('input[name="price_to"]').value = '';
    }

    disableResetFiltersButton() {
        if (!this.resetFiltersButton.hasAttribute('disabled')) {
            this.resetFiltersForm();
            this.resetFiltersButton.setAttribute('disabled', 'disabled');
        }
    }

    enableResetFiltersButton() {
        if (this.resetFiltersButton.hasAttribute('disabled')) {
            this.resetFiltersButton.removeAttribute('disabled');
        }
    }

    setLoadingModeShowMoreButton() {
        this.showMoreButton.classList.add('loading');
    }

    removeLoadingModeShowMoreButton() {
        this.showMoreButton.classList.remove('loading');
    }

    disableShowMoreButton() {
        this.showMoreButton.classList.add('disabled');
    }

    enableShowMoreButton() {
        this.showMoreButton.classList.remove('disabled');
        this.showMoreButton.classList.remove('loading');
    }

    render(tours) {
        if (tours.length === 0) {
            this.toursContainer.innerHTML = `
                <p class="lg:m-3 text-xl text-gray-600 font-light">${LocaleHelper.translate('no-results')}!</p>
            `;
            return;
        }

        tours.forEach(tour => {
            const tourCard = document.createElement('div');
            tourCard.className = 'flex flex-col shadow rounded-md';

            let durationNode = '';

            if (tour.duration) {
                durationNode = `
                    <div class="flex items-center">
                        <svg class="min-w-5 min-w-5 w-5 h-5 mr-2" width="21" height="21" viewBox="0 0 21 21"
                             fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M10.5 1.75C15.3325 1.75 19.25 5.66751 19.25 10.5C19.25 15.3325 15.3325 19.25 10.5 19.25C5.66751
                                                19.25 1.75 15.3325 1.75 10.5C1.75 6.91194 3.90967 3.8283 7 2.47808M10.5 5.25V10.5L14 12.25"
                                stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"/>
                        </svg>
                        <span>${tour.duration}</span>
                    </div>
                `;
            }

            tourCard.innerHTML = `
                <div class="flex justify-end items-start p-3 bg-center bg-cover bg-no-repeat bg-gray-50 rounded-md"
                     style="height: 180px; background-image: url(${tour.image})">
                     <div class="flex justify-center items-center w-8 h-8 bg-white rounded-full cursor-pointer">
                         <svg class="w-5 h-4" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                             <path d="M10.4998 3.76675L9.61235 2.86746C8.74862 1.99218 7.57715 1.50045 6.35566 1.50045C5.13416 1.50045 3.96269 1.99218 3.09897
                                   2.86746C2.23524 3.74274 1.75 4.92987 1.75 6.1677C1.75 9.58687 6.99955 15.5 10.4998 15.5C14 15.5 19.2498 9.58641 19.2498 6.16725C19.2498
                                   4.92942 18.7645 3.74228 17.9008 2.867C17.0371 1.99173 15.8656 1.5 14.6441 1.5C13.7927 1.5 12.9655 1.73892 12.25 2.18012"
                                   stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                         </svg>
                     </div>
                </div>
                <div class="flex flex-col px-4 pb-2 h-full" style="flex: 1">
                    <div class="flex items-center py-3 text-xs 2xl:text-sm text-blue font-semibold">
                        <div class="flex items-center mr-4">
                            <svg class="min-w-5 min-w-5 w-5 h-5 mr-2" viewBox="0 0 21 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                    <path
                                        d="M14 2.73877C14.7529 2.93153 15.4202 3.36938 15.8967 3.98329C16.3732 4.5972 16.6319
                                                    5.35225 16.6319 6.12939C16.6319 6.90654 16.3732 7.66159 15.8967 8.2755C15.4202 8.88941 14.7529 9.32726 14 9.52002"
                                        stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path
                                        d="M7.875 9.625C9.808 9.625 11.375 8.058 11.375 6.125C11.375 4.192 9.808 2.625 7.875
                                                    2.625C5.942 2.625 4.375 4.192 4.375 6.125C4.375 8.058 5.942 9.625 7.875 9.625Z"
                                        stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path
                                        d="M11.3751 18.4994C12.5896 18.2807 13.5525 17.9476 14.0001 17.5C14.063 16.9339 14.0001 16.0416
                                                    14.0001 16.0416C14.0001 15.2681 13.6314 14.5262 12.975 13.9792C10.9022 12.2519 3.97308 12.2519
                                                    1.90025 13.9792C1.24387 14.5262 0.87512 15.2681 0.87512 16.0416C0.87512 16.0416 0.812228 16.9339
                                                    0.87512 17.5C1.32274 17.9476 2.2856 18.2807 3.50012 18.4994"
                                        stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                    <path
                                        d="M17.5 18.4994C18.7145 18.2808 19.6774 17.9476 20.125 17.5C20.1879 16.934 20.125 16.0417 20.125
                                                    16.0417C20.125 15.2681 19.7563 14.5263 19.0999 13.9793C18.714 13.6577 18.1598 13.396 17.5 13.1942"
                                        stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0">
                                        <rect width="21" height="21" fill="white"/>
                                    </clipPath>
                                </defs>
                            </svg>
                            <span>${tour.type}</span>
                        </div>

                        ${durationNode}
                    </div>

                    <p class="mb-2 text-black font-bold leading-5">${tour.title}</p>
                    <p class="mb-4 text-sm text-gray-600 leading-5">${tour.description}</p>

                    <div class="flex items-end" style="flex: 1">
                        <p class="mr-auto text-3xl text-black font-bold">${'$' + tour.price}</p>
                        <div class="flex flex-col items-end pb-0.5">
                            <div class="flex mb-1">
                                <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center" style="background-image: url(/images/active-start.svg)"></div>
                                <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center" style="background-image: url(/images/active-start.svg)"></div>
                                <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center" style="background-image: url(/images/active-start.svg)"></div>
                                <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center" style="background-image: url(/images/active-start.svg)"></div>
                                <div class="min-w-4 min-w-4 w-4 h-4 bg-contain bg-no-repeat bg-center" style="background-image: url(/images/active-start.svg)"></div>
                            </div>
                            <a href="#" class="text-sm text-gray-600 font-medium hover:underline">${LocaleHelper.translate('reviews')} (0)</a>
                        </div>
                    </div>
                </div>
            `;

            this.toursContainer.append(tourCard);
        });
    }
}

export default FilterToursView;
