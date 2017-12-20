define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/translate'
], function($, modal, $t) {
    'use strict';

    $.widget('mage.customLibrary', {
        modalContainer: undefined,

        options: {
            foo: undefined
        },

        /**
         * @private
         */
        _create: function() {
            this.bindAction();
            this.initModal();
        },

        /**
         */
        bindAction: function() {
            this.element.on('click', this.onButtonClick.bind(this));
        },

        /**
         */
        onButtonClick: function() {
            this.modalContainer.modal('openModal');
        },

        /**
         */
        initModal: function() {
            var options = {
                'type': 'popup',
                'modalClass': 'custom-popup',
                'responsive': true,
                'buttons': []
            };

            this.modalContainer = this.getModalContent();
            modal(options, this.modalContainer);
        },

        /**
         * @returns {*|jQuery}
         */
        getModalContent: function() {
            return $('<div/>').append($('<p/>').text(this.options.foo.name));
        }
    });

    return $.mage.customLibrary;
});