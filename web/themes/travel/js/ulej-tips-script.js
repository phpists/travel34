(function () {
    const settings = {
        projectID : '484750',
        values : [{
            'id': '1',
            'BYN': '5',
            'USD': '2,5',
            'compensationId': '484757'
        }, {
            'id': '2',
            'BYN': '10',
            'USD': '5',
            'compensationId': '484760'
        }, {
            'id': '3',
            'BYN': '20',
            'USD': '10',
            'compensationId': '484763'
        }, {
            'id': '4',
            'BYN': '50',
            'USD': '25',
            'compensationId': '484766'
        }, {
            'id': '5',
            'BYN': '100',
            'USD': '50',
            'compensationId': '484769'
        }, {
            'id': '6',
            'BYN': '200',
            'USD': '100',
            'compensationId': '484772'
        }]
    };

    const projectID = settings.projectID;
    const payURL = 'http://ulej.by/pay-step2?project_id=' + projectID + '&compensation_id=';
    const values = settings.values;

    const togglers = document.querySelectorAll('.js-expand');
    const selector = document.querySelector('.js-selector');

    Array.prototype.slice.call(togglers).forEach(function (item) {
        item.addEventListener('click', function (event) {
            if (!selector.classList.contains('is-opened')) {
                selector.classList.add('is-opened');
            } else {
                selector.classList.remove('is-opened');
            }
        });
    });

    function createListItem(item, selected) {
        const id = item.id;
        const BYN = item.BYN;
        const USD = item.USD;
        const content = '<span class="value value--BYN">' + BYN + ' BYN</span><span class="value value--USD">(' + USD + ' USD)</span>';
        let result;
        if (selected) {
            result = content;
        } else {
            result = '<li class="ulej-tips-field__value js-value" data-value="' + id + '">' + content + '</li>';
        }
        return result;
    }

    const selectorList = document.querySelector('.js-values-list');
    const selectorListItems = document.querySelectorAll('.js-value');
    const selectedItem = document.querySelector('.js-selected-value');
    const sendBtn = document.querySelector('.js-send-tips');

    function fillSelected(item, callback) {
        if (typeof item === 'undefined') {
            selected = values[0];
        } else {
            selected = item;
        }
        selectedItem.dataset.value = selected.id;
        selectedItem.innerHTML = createListItem(selected, true);
        setURL(selected.compensationId);
        if (callback && typeof(callback) === 'function') {
            callback();
        }
    }
    fillSelected();

    function getItem(id) {
        return values.filter(function (item) {
            return (item.id === id);
        })[0];
    }

    function fillList(callback) {
        let selectedItemValue = selectedItem.dataset.value;
        let selectedValue = values.filter(function (item) {
            return item.id === selectedItemValue;
        })[0];

        values.filter(function (item) {
            return (item.id !== selectedValue.id);
        }).forEach(function (item) {
            selectorList.insertAdjacentHTML('beforeend', createListItem(item));
        });
        if (callback && typeof(callback) === 'function') {
            callback();
        }
    };
    fillList();

    function updateList() {
        selectorList.innerHTML = '';
        fillList();
    }

    function setURL(compensationId) {
        sendBtn.href = payURL + compensationId + '&' + sendBtn.dataset.utm;
    }

    selectorList.addEventListener('click', function (event) {
        const matches = event.target.matches ? event.target.matches('.js-value') : event.target.msMatchesSelector('.js-value');
        if (event.target && matches) {
            const value = event.target.dataset.value;
            const selected = selectedItem.dataset.value;
            if (selected === value) {
                selector.classList.remove('is-opened');
                return false;
            } else {
                fillSelected(getItem(value), updateList);
                selector.classList.remove('is-opened');
            }
        }
    });
})();
