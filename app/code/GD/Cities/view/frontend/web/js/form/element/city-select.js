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
                regions = this.getCitiesByRegion(regionId);

            if (regions && regions.length) {
                cities = regions;

                options = cities.map(function (city) {
                    return {title: city.default_name, value: city.id, labeltitle: city.default_name, label: city.default_name}
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
        },

        getCitiesByRegion: function(id){
            let dataCities = [];

            $.ajax({
                url : urlBuilder.build('rest/V1/zonification/city/list/' + id),
                type : 'GET',
                async: false,
                showLoader: true,
                dataType:'json',
                success : function(data) {
                    dataCities = data;
                },
                error : function(request,error) {
                    console.log("Cities service error...");
                }
            });

            return dataCities;
        }
    });
});
