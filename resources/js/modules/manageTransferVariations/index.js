import ManageTransferVariationsController from './ManageTransferVariationsController';

document.addEventListener('DOMContentLoaded', _ => {
    const container = document.querySelector('.transfer-cost-container');

    if (container) {
        new ManageTransferVariationsController({
            container,
            createTransferButton: container.querySelector('.create-transfer-button'),
            deleteTransferButton: container.querySelector('.delete-transfer-button'),
            variationsContainer: container.querySelector('.variations-container'),
            variationsWrapper: container.querySelector('.variations-wrapper'),
            loader: document.querySelector('.variations-search-loader')
        });
    }
});