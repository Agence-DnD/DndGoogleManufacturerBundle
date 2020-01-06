'use strict';
/**
 * Google form
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define(
    [
        'underscore',
        'oro/translator',
        'backbone',
        'dnd/template/export/product/edit/google',
        'pim/form'
    ],
    function (
        _,
        __,
        Backbone,
        template,
        BaseForm
    ) {
        return BaseForm.extend({
            template: _.template(template),

            /**
             * {@inheritdoc}
             */
            initialize: function (config) {
                this.config = config.config;

                BaseForm.prototype.initialize.apply(this, arguments);
            },

            /**
             * {@inheritdoc}
             */
            configure: function () {
                this.trigger('tab:register', {
                    code: this.config.tabCode ? this.config.tabCode : this.code,
                    label: __(this.config.tabTitle)
                });
                this.listenTo(this.getRoot(), 'pim_enrich:form:entity:validation_error', this.render.bind(this));

                return BaseForm.prototype.configure.apply(this, arguments);
            },

            /**
             * {@inheritdoc}
             */
            render: function () {
                if (!this.configured) {
                    return this;
                }

                this.$el.html(
                    this.template({})
                );

                this.renderExtensions();
            }
        });
    }
);
