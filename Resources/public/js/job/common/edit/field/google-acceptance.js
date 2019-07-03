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
    'oro/translator',
    'pim/fetcher-registry',
    'dnd/job/common/edit/field/google-acceptance-select'
], function (
    $,
    _,
    __,
    FetcherRegistry,
    SelectField
) {
    return SelectField.extend({
        /**
         * {@inherit}
         */
        configure: function () {
            return $.when(
                FetcherRegistry.getFetcher('google-acceptance').fetchAll(),
                SelectField.prototype.configure.apply(this, arguments)
            ).then(function (formats) {
                this.config.options = formats.acceptances;
            }.bind(this));
        }
    });
});