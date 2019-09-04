define(['ko'], function (ko) {
    'use strict';

    return function (config) {
        const title = ko.observable('Test page for my self. It`s just a title');
        title.subscribe(function (newValue) {
            console.log('New value: "', newValue, '"');
        });
        title.subscribe(function (oldValue) {
            console.log('Has been changed from: "', oldValue, '"');
        }, this, 'beforeChange');
        return {
            title: title,
            config: config
        }
    }
});