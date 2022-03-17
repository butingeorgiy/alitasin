import EventHandler from '../../core/EventHandler';
import SearchPartnersView from './SearchPartnersView';
import SearchPartnersModel from './SearchPartnersModel';

class SearchPartnersController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;

        this.view = new SearchPartnersView({
            loaderIcon: nodes.loaderIcon,
            resultsContainer: nodes.resultsContainer
        });

        this.initSearchable();
        this.initClosingOfResultsContainer();
    }

    initSearchable() {
        let timer;

        this.addEvent(this.nodes.input, 'input', _ => {
            clearTimeout(timer);

            const searchString = this.nodes.input.value;

            if (!searchString.replace(/\s/g, '') || searchString === '') {
                this.view.hideLoading();
                this.view.hideResultsContainer();
                return;
            }

            this.view.showLoading();

            timer = setTimeout(_ => this.fetchPartners(searchString), 500);
        });
    }

    initClosingOfResultsContainer() {
        this.addEvent(window, 'click', e => {
            for (let node of e.path) {
                if (/partners-search-wrapper/.test(node.className)) {
                    return;
                }
            }

            this.view.hideLoading();
            this.view.hideResultsContainer();
        });
    }

    fetchPartners(query) {
        SearchPartnersModel.search(query)
            .then(result => {
                this.view.clearResultsContainer();
                this.view.showResultsContainer();

                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result}`);
                } else {
                    if (result['result'].length === 0) {
                        this.view.showEmptyMessage();
                    } else {
                        this.view.renderResults(result['result']);
                    }
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.view.hideLoading();
            });
    }
}

export default SearchPartnersController;