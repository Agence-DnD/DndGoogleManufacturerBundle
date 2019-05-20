'use strict';
/**
 * Mandatory structure
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define([
    'jquery',
    'underscore',
    'oro/translator',
    'pim/user-context',
    'pim/fetcher-registry',
    'pim/job/common/edit/field/select',
    'dnd/template/export/common/edit/field/select'
], function (
    $,
    _,
    __,
    UserContext,
    FetcherRegistry,
    SelectField,
    fieldTemplate
) {
    return SelectField.extend({
        fieldTemplate: _.template(fieldTemplate),

        /**
         * {@inherit}
         */
        configure: function () {
            return $.when(
                FetcherRegistry.getFetcher('attributes-list').fetchAll(),
                SelectField.prototype.configure.apply(this, arguments)
            ).then(function (attributes) {
                if (_.isEmpty(attributes)) {
                    this.config.readOnly = true;
                    this.config.options = {'NO OPTION': __('dnd_google_shopping.google_attribute_reader.attribute.no_attribute')};
                } else {
                    let options = {};
                    let attributeList = attributes.map((attribute) => {
                        const catalogLocale = UserContext.get('uiLocale');
                        const label = this.getEntityLabel(attribute, catalogLocale);

                        return {
                            id: attribute.code,
                            text: label
                        };
                    });
                    for (var i in attributeList) {
                        let attr = attributeList[i];
                        if (attr.hasOwnProperty('id') && attr.hasOwnProperty('text')) {
                            options[attr['id']] = attr['text'];
                        }
                    }
                    this.config.options = options;
                }
            }.bind(this));
        },

        /**
         * Return the label/code of a serialized entity.
         *
         * @param {string} entity
         * @param {string} locale
         * @returns {string}
         */
        getEntityLabel(entity, locale) {
            if (0 === entity.labels.length || entity.labels[locale] === undefined) {
                return '[' + entity.code + ']';
            }

            return entity.labels[locale];
        }
    });
});