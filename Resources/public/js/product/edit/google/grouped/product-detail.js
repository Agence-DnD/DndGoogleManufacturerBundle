'use strict';

/**
 * Extension to display breadcrumbItems on every page
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
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
            className: 'AknFieldContainer DndAknFieldContainer',
            template: _.template(template),

            /**
             * Initializes configuration.
             *
             * @param {Object} config
             */
            initialize: function (config) {
                this.config = config;
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
