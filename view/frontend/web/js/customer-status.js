define([
    'jquery',
    'uiComponent'
], function ($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            formKeyHtml: '',
            template: 'Magenius_CustomerStatus/status-form',
            status: '',
            saveUrl: ''
        },

        initObservable: function () {
            this._super()
                .observe({
                    status: this.status
                });
            return this;
        },

        save: function (data, event) {
            let formData = $("[data-role=status-form]").serialize();
            $.post(this.saveUrl, formData).error(function () {
                alert('Something went wrong');
            }).success(function (data) {
                alert(data.message);
            });
        }
    });
});