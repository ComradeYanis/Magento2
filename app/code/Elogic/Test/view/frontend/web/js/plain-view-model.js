define(['ko', 'jquery'], function (ko, $) {
    'use strict';

    return function () {
        const viewModel = {
            exchange_rates: ko.observable([
                1,
                2,
                3,
                4
            ])
        };
        return viewModel;
    }
});