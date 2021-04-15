import EventHandler from '../../core/EventHandler';
import FilterToursModel from './FilterToursModel';
import FilterToursView from "./FilterToursView";

class FilterToursController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;
        this.shoudShowMore = true;
        this.offsetStep = 15;
        this.offset = 0;
        this.filters = {
            'filters': [],
            'types': [],
            'min-price': null,
            'max-price': null
        };

        this.view = new FilterToursView({
            toursContainer: nodes.toursContainer,
            resetFiltersButton: nodes.resetFiltersButton,
            filtersContainer: nodes.filtersContainer,
            showMoreButton: nodes.showMoreButton
        });

        this.changeFiltersAttachHandlers();
        this.addEvent(nodes.resetFiltersButton, 'click', _ => this.resetFilters());
        this.addEvent(nodes.showMoreButton, 'click', _ => {
            if (!this.loading && this.shoudShowMore) {
                this.fetchTours();
            }
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

        if (this.offset !== 0) {
            uri += `offset=${this.offset}`;
        }

        return uri === '?' ? '' : uri;
    }

    resetFilters() {
        this.shoudShowMore = true;
        this.offset = -this.offsetStep;
        this.filters = {
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

        if (JSON.stringify(this.filters) === JSON.stringify({
            'filters': [],
            'types': [],
            'min-price': null,
            'max-price': null
        })) {
            this.view.disableResetFiltersButton();
        } else {
            this.view.enableResetFiltersButton();
        }

        this.fetchTours('filter');
    }

    fetchTours(mode = 'show-more') {
        this.loading = true;
        this.view.setLoadingModeShowMoreButton();
        this.offset += this.offsetStep;

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

                if (mode === 'filter') {
                    this.view.clearContainer();
                } else if (mode === 'show-more') {
                    if (result.length < this.offsetStep) {
                        this.shoudShowMore = false;
                        this.view.disableShowMoreButton();
                    }
                }

                this.view.render(result);
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.view.removeLoadingModeShowMoreButton();
                this.loading = false;
            });
    }
}

export default FilterToursController;
