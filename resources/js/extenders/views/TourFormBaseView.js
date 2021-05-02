import LocaleHelper from '../../helpers/LocaleHelper';

class TourFormBaseView {
    constructor(nodes) {
        this.error = nodes.error;
        this.success = nodes.success;
        this.btn = nodes.btn;
        this.additionPopupError = nodes.additionPopupError;
        this.includesAdditionsContainer = nodes.includesAdditionsContainer;
        this.notIncludesAdditionsContainer = nodes.notIncludesAdditionsContainer;
    }

    static renderImage(node, image) {
        node.classList.add('filled')
        node.style.backgroundImage = `url(${image})`;
    }

    static removeImage(node) {
        node.classList.remove('filled');
        node.style.backgroundImage = '';
    }

    hideMessages() {
        this.error.classList.add('hidden');
        this.success.classList.add('hidden');
    }

    showError(msg) {
        document.body.classList.add('shake');

        setTimeout(_ => {
            document.body.classList.remove('shake');
        }, 200);

        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerText = msg;
    }

    showSuccess(msg) {
        this.success.classList.remove('hidden');
        this.success.querySelector('span').innerText = msg;
    }

    showLoader() {
        this.btn.classList.add('loading');
    }

    hideLoader() {
        this.btn.classList.remove('loading');
    }

    showAdditionPopupError(msg) {
        this.additionPopupError.classList.remove('hidden');
        this.additionPopupError.querySelector('span').innerText = msg;
    }

    hideAdditionPopupError() {
        this.additionPopupError.classList.add('hidden');
        this.additionPopupError.querySelector('span').innerText = '';
    }

    renderAdditions(additions, dettachAdditionHandler, editAdditionHandler) {
        let includeCount = 0, notIncludeCount = 0;

        this.includesAdditionsContainer.innerHTML = '';
        this.notIncludesAdditionsContainer.innerHTML = '';

        additions.forEach(addition => {
            let additionNode = document.createElement('div'), icon = '';

            additionNode.className = 'flex items-start ml-2 mb-3 last:mb-0';

            if (addition.is_include === '1') {
                includeCount++;
                icon = `
                    <svg class="relative top-1 min-w-4 w-4 mr-3" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.7319 0.295798C13.639 0.20207 13.5284 0.127675 13.4065 0.0769067C13.2846 0.026138 13.1539 0 13.0219 0C12.8899 0 12.7592 0.026138
                                      12.6373 0.0769067C12.5155 0.127675 12.4049 0.20207 12.3119 0.295798L4.86192 7.7558L1.73192 4.6158C1.6354 4.52256 1.52146 4.44925 1.3966
                                      4.40004C1.27175 4.35084 1.13843 4.32671 1.00424 4.32903C0.870064 4.33135 0.737655 4.36008 0.614576 4.41357C0.491498 4.46706 0.380161
                                      4.54428 0.286922 4.6408C0.193684 4.73732 0.12037 4.85126 0.0711659 4.97612C0.0219619 5.10097 -0.00216855 5.2343 0.000152918 5.36848C0.00247438
                                      5.50266 0.0312022 5.63507 0.0846957 5.75814C0.138189 5.88122 0.215401 5.99256 0.311922 6.0858L4.15192 9.9258C4.24489 10.0195 4.35549 10.0939
                                      4.47735 10.1447C4.59921 10.1955 4.72991 10.2216 4.86192 10.2216C4.99393 10.2216 5.12464 10.1955 5.2465 10.1447C5.36836 10.0939 5.47896
                                      10.0195 5.57192 9.9258L13.7319 1.7658C13.8334 1.67216 13.9144 1.5585 13.9698 1.432C14.0252 1.30551 14.0539 1.1689 14.0539 1.0308C14.0539
                                      0.892697 14.0252 0.756092 13.9698 0.629592C13.9144 0.503092 13.8334 0.389441 13.7319 0.295798V0.295798Z" fill="#0094FF"/>
                    </svg>
                `;
            } else {
                notIncludeCount++;
                icon = `
                    <svg class="relative top-1 min-w-4 w-4 mr-3" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.05749 5.99936L11.7796 1.28477C11.9207 1.14363 12 0.952206 12 0.752604C12 0.553001 11.9207 0.361573 11.7796
                              0.220433C11.6384 0.079292 11.447 0 11.2474 0C11.0478 0 10.8564 0.079292 10.7152 0.220433L6.00064 4.94251L1.28605
                              0.220433C1.14491 0.079292 0.953486 1.77216e-07 0.753883 1.78703e-07C0.55428 1.80191e-07 0.362852 0.079292 0.221712
                              0.220433C0.0805711 0.361573 0.00127934 0.553001 0.00127934 0.752604C0.00127934 0.952206 0.0805711 1.14363 0.221712
                              1.28477L4.94379 5.99936L0.221712 10.7139C0.151459 10.7836 0.0956977 10.8665 0.0576447 10.9579C0.0195917 11.0492 0
                              11.1472 0 11.2461C0 11.3451 0.0195917 11.443 0.0576447 11.5344C0.0956977 11.6257 0.151459 11.7086 0.221712 11.7783C0.291391
                              11.8485 0.37429 11.9043 0.465628 11.9424C0.556966 11.9804 0.654935 12 0.753883 12C0.852831 12 0.950799 11.9804
                              1.04214 11.9424C1.13348 11.9043 1.21637 11.8485 1.28605 11.7783L6.00064 7.05621L10.7152 11.7783C10.7849 11.8485 10.8678
                              11.9043 10.9591 11.9424C11.0505 11.9804 11.1484 12 11.2474 12C11.3463 12 11.4443 11.9804 11.5357 11.9424C11.627 11.9043
                              11.7099 11.8485 11.7796 11.7783C11.8498 11.7086 11.9056 11.6257 11.9436 11.5344C11.9817 11.443 12.0013 11.3451 12.0013
                              11.2461C12.0013 11.1472 11.9817 11.0492 11.9436 10.9579C11.9056 10.8665 11.8498 10.7836 11.7796 10.7139L7.05749 5.99936Z"
                              fill="#FF3D3D"/>
                    </svg>
                `;
            }

            additionNode.innerHTML = `
                ${icon}
                <div class="flex flex-col">
                    <div class="flex items-center">
                        <p class="mr-5 text-black font-medium">${addition.title}</p>
                        <span class="edit-addition-button mr-2 text-sm text-gray-500 cursor-pointer whitespace-nowrap hover:underline">${LocaleHelper.translate('edit')}</span>
                        <span class="dettach-addition-button text-sm text-red-500 cursor-pointer whitespace-nowrap hover:underline">${LocaleHelper.translate('delete')}</span>
                    </div>
                    <p class="text-sm text-gray-400 italic">En:&nbsp;&nbsp;${addition.en_description || 'Ничего не указано'}</p>
                    <p class="text-sm text-gray-400 italic">Ru:&nbsp;&nbsp;${addition.ru_description || 'Ничего не указано'}</p>
                    <p class="text-sm text-gray-400 italic">Tr:&nbsp;&nbsp;${addition.tr_description || 'Ничего не указано'}</p>
                </div>
            `;

            dettachAdditionHandler(additionNode.querySelector('.dettach-addition-button'), addition.id);
            editAdditionHandler(additionNode.querySelector('.edit-addition-button'), addition);

            if (addition.is_include === '1') {
                this.includesAdditionsContainer.append(additionNode);
            } else {
                this.notIncludesAdditionsContainer.append(additionNode);
            }
        });

        if (includeCount === 0) {
            this.includesAdditionsContainer.innerHTML = `
                <p class="text-sm text-black font-light italic">${LocaleHelper.translate('empty-list')}</p>
            `;
        }

        if (notIncludeCount === 0) {
            this.notIncludesAdditionsContainer.innerHTML = `
                <p class="text-sm text-black font-light italic">${LocaleHelper.translate('empty-list')}</p>
            `;
        }
    }
}

export default TourFormBaseView;
