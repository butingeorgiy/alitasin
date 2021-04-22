import EventHandler from '../../core/EventHandler';
import FilterToursModel from './FilterToursModel';
import FilterToursView from "./FilterToursView";
import LocaleHelper from '../../helpers/LocaleHelper';

class FilterToursController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;
        this.shoudShowMore = !nodes.showMoreButton.classList.contains('disabled');
        this.isAdmin = nodes.toursSection.getAttribute('data-is-admin') === '1';
        this.offsetStep = 15;
        this.offset = 0;
        this.filters = {
            'filters': [],
            'types': [],
            'min-price': null,
            'max-price': null,
            'search-string': null
        };

        this.view = new FilterToursView({
            toursContainer: nodes.toursContainer,
            resetFiltersButton: nodes.resetFiltersButton,
            filtersContainer: nodes.filtersContainer,
            showMoreButton: nodes.showMoreButton,
            searchInput: nodes.searchInput
        });

        this.changeFiltersAttachHandlers();
        this.initSearchInput();
        this.addEvent(nodes.resetFiltersButton, 'click', _ => this.resetFilters());
        this.addEvent(nodes.showFiltersButton, 'click', e => this.view.toggleFiltersForm(e.currentTarget));
        this.addEvent(nodes.showMoreButton, 'click', _ => {
            if (!this.loading && this.shoudShowMore) {
                this.fetchTours();
            }
        });

        nodes.toursContainer.querySelectorAll('.move-to-update-page').forEach(btn => {
            this.addEvent(btn, 'click', e => {
                e.preventDefault();
                this.moveToUpdateTourPage(btn.getAttribute('data-tour-id'));
            });
        });

        nodes.toursContainer.querySelectorAll('.delete-tour-button').forEach(btn => {
            this.addEvent(btn, 'click', e => {
                e.preventDefault();
                this.deleteTour(btn.getAttribute('data-tour-id'), btn.parentNode.parentNode);
            });
        });

        this.deleteTour = this.deleteTour.bind(this);
    }

    initSearchInput() {
        let timer, searchString;

        this.addEvent(this.nodes.searchInput, 'input', _ => {
            clearTimeout(timer);
            searchString = this.nodes.searchInput.value;
            this.view.enableShowMoreButton();
            this.offset = -this.offsetStep;
            this.shoudShowMore = true;

            if (!searchString.replace(/\s/g, '') && searchString !== '') {
                this.view.hideSearchLoading();
                return;
            }

            this.view.showSearchLoading();

            if (!searchString) {
                this.filters['search-string'] = null;
                this.view.hideSearchLoading();
                this.fetchTours('search');
                return;
            }

            timer = setTimeout(_ => {
                this.filters['search-string'] = this.nodes.searchInput.value;
                this.fetchTours('search');
            }, 500);
        });
    }

    changeFiltersAttachHandlers() {
        // Filters changing handler
        this.nodes.filterButtons.forEach(node => {
            this.addEvent(node, 'click', e => {
                if (!this.loading) {
                    this.loading = true;
                    FilterToursView.tabActiveToggle(e.currentTarget);
                    this.changeFilters('filters', e.currentTarget.getAttribute('data-filter-id'));
                }
            });
        });

        // Types changing handler
        this.nodes.typeButtons.forEach(node => {
            this.addEvent(node, 'click', e => {
                if (!this.loading) {
                    this.loading = true;
                    FilterToursView.tabActiveToggle(e.currentTarget);
                    this.changeFilters('types', e.currentTarget.getAttribute('data-type-id'));
                }
            });
        });

        // Min price changing handler
        let minPriceChangeTimer;
        this.nodes.minPriceInput.addEventListener('input', _ => {
            clearTimeout(minPriceChangeTimer);

            minPriceChangeTimer = setTimeout(_ => {
                this.changeFilters('min-price', this.nodes.minPriceInput.value);
            }, 500);
        });

        // Max price changing handler
        let maxPriceChangeTimer;
        this.nodes.maxPriceInput.addEventListener('input', _ => {
            clearTimeout(maxPriceChangeTimer);

            maxPriceChangeTimer = setTimeout(_ => {
                this.changeFilters('max-price', this.nodes.maxPriceInput.value);
            }, 500);
        });
    }

    convertFiltersToUri() {
        let uri = '?';

        if (this.filters['filters'].length !== 0) {
            uri += `filters=${JSON.stringify(this.filters['filters'])}&`;
        }

        if (this.filters['types'].length !== 0) {
            uri += `types=${JSON.stringify(this.filters['types'])}&`;
        }

        if (this.filters['min-price']) {
            uri += `min_price=${this.filters['min-price']}&`;
        }

        if (this.filters['max-price']) {
            uri += `max_price=${this.filters['max-price']}&`;
        }

        if (this.filters['search-string']) {
            uri += `search_string=${this.filters['search-string']}&`;
        }

        if (this.offset !== 0) {
            uri += `offset=${this.offset}&`;
        }

        if (/^\/regions\/\d+$/.test(location.pathname)) {
            uri += `region_id=${location.pathname.split('/')[2]}`;
        }

        return uri === '?' ? '' : uri;
    }

    resetFilters() {
        this.shoudShowMore = true;
        this.offset = -this.offsetStep;
        this.filters = {
            ...this.filters,
            'filters': [],
            'types': [],
            'min-price': null,
            'max-price': null
        };

        this.view.enableShowMoreButton();
        this.view.disableResetFiltersButton();
        this.fetchTours('filter');
    }

    changeFilters(key, value) {
        this.offset = -this.offsetStep;
        this.shoudShowMore = true;
        this.view.enableShowMoreButton();

        switch (key) {
            case 'filters':
                if (this.filters['filters'].includes(value)) {
                    this.filters['filters'].splice(this.filters['filters'].indexOf(value), 1);
                } else {
                    this.filters['filters'].push(value);
                }
                break;
            case 'types':
                if (this.filters['types'].includes(value)) {
                    this.filters['types'].splice(this.filters['types'].indexOf(value), 1);
                } else {
                    this.filters['types'].push(value);
                }
                break;
            case 'min-price':
                this.filters['min-price'] = (value === '' ? null : value);
                break;
            case 'max-price':
                this.filters['max-price'] = (value === '' ? null : value);
                break;
            default:
                console.error('Undefined filter field!');
        }

        if (!this.isFiltersHasChanges()) {
            this.view.disableResetFiltersButton();
        } else {
            this.view.enableResetFiltersButton();
        }

        this.fetchTours('filter');
    }

    isFiltersHasChanges() {
        return this.filters['filters'].length !== 0 ||
            this.filters['types'].length !== 0 ||
            this.filters['min-price'] !== null ||
            this.filters['max-price'] !== null;
    }

    moveToUpdateTourPage(tourId) {
        window.open(`${location.origin}/admin/tours/update/${tourId}`);
    }

    deleteTour(tourId, tourCardNode) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        FilterToursModel.delete(tourId)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    return;
                }

                if (result.error) {
                    alert(`Error: ${result.message}`);
                    return;
                }

                alert(result.message);
                this.view.removeTourCard(tourCardNode);
            })
            .catch(error => alert(`Error: ${error}`));
    }

    fetchTours(mode = 'show-more') {
        this.loading = true;
        this.view.setLoadingModeShowMoreButton();
        this.offset += this.offsetStep;

        console.log(this.convertFiltersToUri());

        FilterToursModel.search(this.convertFiltersToUri())
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    return;
                }

                if (result.error) {
                    alert(`Error: ${result.message}`);
                    return;
                }

                if (mode === 'filter' || mode === 'search') {
                    this.view.clearContainer();
                }

                if (result.length < this.offsetStep) {
                    this.shoudShowMore = false;
                    this.view.disableShowMoreButton();
                }

                this.view.render(result, this.isAdmin, this.moveToUpdateTourPage, this.deleteTour);

                if (this.view.getCardsAmount() === 0) {
                    this.view.showEmptyIndicator();
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.view.removeLoadingModeShowMoreButton();
                this.view.hideSearchLoading();
                this.loading = false;
            });
    }
}

export default FilterToursController;
