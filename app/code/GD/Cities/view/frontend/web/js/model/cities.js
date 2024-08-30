/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/url'
], function ($, urlBuilder) {
    'use strict';

    return function (id) {
        let dataCities = [];
        let cities = [];
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

        $.each(dataCities, function (index, value) {
            cities.push({"id":value.id, "value":value.default_name});
        });

        return cities;
    };
});
