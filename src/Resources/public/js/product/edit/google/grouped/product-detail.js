'use strict';

/**
 * Product detail section
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define([
        'jquery',
        'underscore',
        'oro/translator',
        'dnd/template/export/product/edit/google/grouped/product-detail',
        'pim/form'
    ],
    function (
        $,
        _,
        __,
        template,
        BaseForm
    ) {
        return BaseForm.extend({
            config: {},
            data: {},
            events: {},
            className: 'AknFieldContainer DndAknFieldContainer',
            template: _.template(template),

            /**
             * Initializes configuration.
             *
             * @param {Object} config
             */
            initialize: function (config) {
                this.config = config;
                this.events = {};
                this.identifier = config.blockId ? config.blockId : 1;
                this.data =
                    (
                        false === _.has(config, 'googleProductDetail') ||
                        true === _.isUndefined(config.googleProductDetail) ||
                        false === _.has(config.googleProductDetail, this.identifier) ||
                        true === _.isUndefined(config.googleProductDetail[this.identifier])
                    )
                        ? null
                        : config.googleProductDetail[this.identifier]
                ;

                return BaseForm.prototype.initialize.apply(this, arguments);
            },

            /**
             * Renders scopes dropdown.
             *
             * @return {Object}
             */
            render: function () {

                return this.$el.html(
                    this.template({
                        __: __,
                        data: this.data,
                        id: this.identifier
                    })
                );
            },
        });
    });
