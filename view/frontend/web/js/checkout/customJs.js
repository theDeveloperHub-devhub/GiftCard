define(
    [
        'ko',
        'jquery',
        'uiComponent',
        'mage/url',
        'Magento_Checkout/js/action/get-totals'
    ],
    function (ko, $, Component, url, getTotalsAction) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'DeveloperHub_GiftCard/checkout/customField',
                myValue: ko.observable(""),
                cleared: ko.observable(false),
            },

            clearValue: function () {
                this.cleared(true);

                var linkUrls = url.build('developerhub/path/check');

                $.ajax({
                    showLoader: true,
                    url: linkUrls,
                    data: {myValue: this.myValue()},
                    type: "POST",
                    dataType: 'json'
                }).done(function (data) {
                    document.getElementById("show").innerHTML= "";
                        if (data.value) {
                            $('#show').append(`<span style="color: green">${data.response}</span>`);

                            $('.subtotal .price').text(data.subtotal);
                            $('.grand.totals .price').text(data.subtotal);
                        } else {
                            $('#show').append(`<span style="color: red">${data.response}</span>`);
                        }
                });
            }
        });
    }
);

