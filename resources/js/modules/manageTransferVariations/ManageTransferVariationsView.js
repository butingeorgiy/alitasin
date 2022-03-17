import LocaleHelper from '../../helpers/LocaleHelper';

class ManageTransferVariationsView {
    constructor(nodes) {
        this.loader = nodes.loader;
        this.container = nodes.container;
        this.variationsWrapper = nodes.variationsWrapper;
        this.variationsContainer = nodes.variationsContainer;
        this.createTransferButton = nodes.createTransferButton;
        this.deleteTransferButton = nodes.deleteTransferButton;
    }

    renderVariations(data, saveCostHandler, deleteCostHandler) {
        data.forEach(item => {
            this.variationsContainer.insertAdjacentElement(
                'beforeend',
                this.makeVariationNode(item, saveCostHandler, deleteCostHandler)
            );
        });
    }

    makeVariationNode(params, saveCostHandler, deleteCostHandler) {
        const node = document.createElement('div');

        node.className = 'grid grid-cols-12 gap-10 mb-1.5';
        node.innerHTML = `
            <div class="col-span-3 mb-2 text-gray-600 leading-5">${params['type_name']}</div>
            <div class="col-span-2 mb-2 text-gray-600 leading-5">${params['capacity_name']}</div>
            <div class="col-span-2 mb-2 text-gray-600 leading-5"><input type="number" value="${params['price'] || ''}" placeholder="Не указано"></div>
            <div class="col-span-5 mb-2 text-gray-600 leading-5">
                <span class="save-transfer-cost mr-4 text-sm text-blue font-semibold whitespace-nowrap cursor-pointer hover:underline">${LocaleHelper.translate('save')}</span>
                <span class="delete-transfer-cost text-sm text-red font-semibold whitespace-nowrap ${params['price'] ? 'cursor-pointer hover:underline' : 'opacity-50 cursor-not-allowed'}">${LocaleHelper.translate('delete')}</span>
            </div>
        `;

        const input = node.querySelector('input');
        const saveButton = node.querySelector('.save-transfer-cost');
        const deleteButton = node.querySelector('.delete-transfer-cost');

        const onDelete = _ => {
            deleteCostHandler(params['type_id'], params['capacity_id'], afterDeletingHandler);
        };

        const afterDeletingHandler = _ => {
            input.value = '';
            deleteButton.removeEventListener('click', onDelete);
            deleteButton.classList.remove('cursor-pointer', 'hover:underline');
            deleteButton.classList.add('opacity-50', 'cursor-not-allowed');
        };

        saveButton.addEventListener('click', _ => {
            saveCostHandler(params['type_id'], params['capacity_id'], input.value);
        });

        if (params['price'] !== null) {
            deleteButton.addEventListener('click', onDelete);
        }

        return node;
    }

    clearVariations() {
        this.variationsContainer.innerHTML = '';
    }

    showLoader() {
        this.loader.classList.remove('hidden');
    }

    hideLoader() {
        this.loader.classList.add('hidden');
    }

    showContainer() {
        this.container.classList.remove('hidden');
    }

    hideContainer() {
        this.container.classList.add('hidden');
    }

    showVariationsWrapper() {
        this.variationsWrapper.classList.remove('hidden');
    }

    hideVariationsWrapper() {
        this.variationsWrapper.classList.add('hidden');
    }

    toggleManageButtons(showButton = 'delete') {
        if (showButton === 'delete') {
            this.createTransferButton.classList.add('hidden');
            this.deleteTransferButton.classList.remove('hidden');
        } else if (showButton === 'create') {
            this.createTransferButton.classList.remove('hidden');
            this.deleteTransferButton.classList.add('hidden');
        }
    }
}

export default ManageTransferVariationsView;