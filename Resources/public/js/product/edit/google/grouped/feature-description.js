'use strict';
/**
 * Feature description section
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define(
    [
        'jquery',
        'underscore',
        'oro/translator',
        'dnd/template/export/product/edit/google/grouped/feature-description',
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
            identifier: null,
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
                this.identifier = config.blockId ? config.blockId : 1;
                this.data =
                    (
                        false === _.has(config, 'googleFeatureDescription') ||
                        true === _.isUndefined(config.googleFeatureDescription) ||
                        false === _.has(config.googleFeatureDescription, this.identifier) ||
                        true === _.isUndefined(config.googleFeatureDescription[this.identifier])
                    )
                    ? null
                    : config.googleFeatureDescription[this.identifier]
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
    }
);
