'use strict';
/**
 * Scope structure filter
 *
 * @author    Julien Sanchez <julien@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define(
    [
        'jquery',
        'underscore',
        'oro/translator',
        'dnd/template/export/product/edit/google/grouped/feature-description',
        'pim/form',
        'pim/fetcher-registry',
        'pim/user-context',
        'jquery.select2',
        'pim/i18n'
    ],
    function (
        $,
        _,
        __,
        template,
        BaseForm,
        fetcherRegistry,
        UserContext,
        select2,
        i18n
    ) {
        return BaseForm.extend({
            config: {},
            data: {},
            className: 'AknFieldContainer',
            template: _.template(template),

            /**
             * Initializes configuration.
             *
             * @param {Object} config
             */
            initialize: function (config) {
                this.config = config;
                this.data = (_.isUndefined(config.googleFeatureDescription)) ? [] : config.googleFeatureDescription;

                return BaseForm.prototype.initialize.apply(this, arguments);
            },

            configure: function() {
            },

            /**
             * Renders scopes dropdown.
             *
             * @return {Object}
             */
            render: function (attributes) {
                return this.$el.html(
                    this.template({
                        __: __,
                        data: this.data,
                        attributes: attributes
                    })
                );
            },
        });
    }
);
