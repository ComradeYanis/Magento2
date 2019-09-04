define(['ko', 'jquery'], function (ko, $) {
    'use strict';

    return function (config) {
        let currencyInfo = ko.observable();
        $.getJSON(config.base_url + 'rest/V1/directory/currency', currencyInfo)

        const viewModel = {
            label: ko.observable('Test info')
        };
        viewModel.output = ko.computed(function () {
            return this.label() + ':\n' + JSON.stringify(currencyInfo(), null, 2);
        }.bind(viewModel));
        return viewModel;
    }
});