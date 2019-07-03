'use strict';

/**
 * Scope structure filter
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define([
    'jquery',
    'underscore',
    'pim/job/common/edit/field/field',
    'dnd/template/export/common/edit/field/google-acceptance-select',
    'jquery.select2'
], function (
    $,
    _,
    BaseField,
    fieldTemplate
) {
    return BaseField.extend({
        fieldTemplate: _.template(fieldTemplate),
        events: {
            'change select': 'updateState'
        },

        /**
         * {@inheritdoc}
         */
        render: function () {
            BaseField.prototype.render.apply(this, arguments);

            $(this.$el).addClass('DndGoogleAcceptanceCustomField');
            this.$('.select2').select2();
        },

        /**
         * Get the field dom value
         *
         * @return {string}
         */
        getFieldValue: function () {
            return this.$('select').val();
        }
    });
});