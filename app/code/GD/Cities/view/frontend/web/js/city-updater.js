define([
    'jquery',
    'GD_Cities/js/model/cities',
    'mage/utils/wrapper',
    'mage/template',
    'mage/validation',
    'underscore',
    'jquery/ui'
], function ($,citiesModel) {
    'use strict';
    return function (params) {

        var string = JSON.stringify(params.cities),
            obj = JSON.parse(string),
            cityInput = $("[name*='city']").val();

        $(document).ready(function (){
            var region_id = $("[name*='region_id']").val();
            var region = [];

            if (region_id) {

                $.each(obj, function (index, value) {
                    if (value.region_id == region_id) {
                        region.push(value.city_name);
                    }
                });
                var city = $("[name*='city']"),
                    selectCity = city.replaceWith("<select class='required-entry' name='city' id='city'>") + '</select>',
                    htmlSelect = '<option>Selecciona la Ciudad</option>',
                    options;

                $.each(region, function (index, value) {
                    if ( value.toLowerCase() == cityInput.toLowerCase()) {
                        options = '<option value="' + value + '" selected>' + value + '</option>';
                    } else {
                        options = '<option value="' + value + '">' + value + '</option>';
                    }

                    htmlSelect += options;
                });

                $('#city').append(htmlSelect);
            }

        });

        $(document).on('change', "[name*='region_id']", function () {

            var region_id = $(this).val(),
                regionName = this.name,
                cityInputName = regionName.replace("region_id", "city"),
                region = [];

            let obj = citiesModel(region_id);

            if (region_id) {
                $.each(obj, function (index, value) {
                    if (value.region_id == region_id) {
                        region.push(value.value);
                    }
                });
                var city = $("[name*='" + cityInputName + "']"),
                    selectCity = city.replaceWith("<select class='required-entry' name='"+cityInputName+"' id='city'>") + '</select>',
                    htmlSelect = '<option>Selecciona la ciudad</option>',
                    options;

                $.each(obj, function (index, value) {
                    options = '<option value="' + value.value + '">' + value.value + '</option>';
                    htmlSelect += options;
                });

                $('#city').append(htmlSelect);
            }

        });
    };
});
