/**
 * @api
 */
define([
    'jquery',
    'Magento_Ui/js/form/element/select',
    'GD_Cities/js/model/cities',
    'mage/url',
    'uiRegistry',
], function ($, Element, citiesModel, urlBuilder, registry) {
    'use strict';

    return Element.extend({
        defaults: {
            imports: {
                update: '${ $.parentName }.region_id:value',
                city: '${ $.parentName }.city'
            },
            options: [],
            visible: false
        },

        initialize: function () {
            this._super();

            if (this.name.includes('steps.billing-step')) {
                this.visible(false)
            }
        },

        /**
         * On region update we check for city
         *
         * @param {string} regionId
         */
        update: function (regionId) {
            let options = [],
                cityValue,
                cities,
                regions = citiesModel(regionId);

            if (regions && regions.length) {
                cities = regions;

                options = cities.map(function (city) {
                    return {title: city.value, value: city.value, labeltitle: city.value, label: city.value}
                })
            }

            if (!options || !options.length) {
                this.visible(false);
                this.value(null);
            }

            if (options && options.length) {
                options = [{title: "", value: "", label: "Selecciona la Ciudad"}].concat(options);
                this.visible(true);

                cityValue = registry.get(this.imports.city).value();

                if (!this.value() && cityValue) {
                    this.value(cityValue)
                }
            }
            this.options(options);
        }

    });
});
