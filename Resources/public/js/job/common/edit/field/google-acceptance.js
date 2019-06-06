'use strict';

define([
    'jquery',
    'underscore',
    'oro/translator',
    'pim/fetcher-registry',
    'pim/job/common/edit/field/select'
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
