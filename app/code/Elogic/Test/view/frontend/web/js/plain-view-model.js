define(['ko', 'jquery'], function (ko, $) {
    'use strict';

    return function () {
        const viewModel = {
            exchange_rates: ko.observable([
                {
                    currency_to: 'USD',
                    rate: 1.0
                }
            ])
        };
        return viewModel;
    }
});