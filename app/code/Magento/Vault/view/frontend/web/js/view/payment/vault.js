/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
/*browser:true*/
/*global define*/
define(
    [
        'underscore',
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        _,
        Component,
        rendererList
    ) {
        'use strict';

        _.each(window.checkoutConfig.payment.vault, function (config, index) {
            rendererList.push(
                {
                    type: index,
                    config: config.config,
                    component: config.component,

                    /**
                     * Custom payment method types comparator
                     * @param {String} typeA
                     * @param {String} typeB
                     * @return {Boolean}
                     */
                    typeComparatorCallback: function (typeA, typeB) {
                        // vault token items have the same name as vault payment without index
                        return typeA.substring(0, typeA.lastIndexOf('_')) === typeB;
                    }
                }
            );
        });

        /**
         * Add view logic here if needed
         */
        return Component.extend({});
    }
);
