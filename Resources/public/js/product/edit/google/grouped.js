'use strict';
/**
 * Structure section
 *
 * @author    Julien Sanchez <julien@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define(
    [
        'underscore',
        'oro/translator',
        'dnd/template/export/product/edit/google/grouped',
        'dnd/job/export/product/edit/google/grouped/feature-description',
        'dnd/job/export/product/edit/google/grouped/product-detail',
        'pim/form',
        'pim/fetcher-registry',
        'pim/common/property',
        'pim/initselect2',
    ],
    function (
        _,
        __,
        template,
        DndGoogleFeatureDescriptionBlock,
        DndGoogleProductDetailBlock,
        BaseForm,
        fetcherRegistry,
        propertyAccessor,
        initSelect2,
    ) {
        return BaseForm.extend({
            targetFieldDescription: 'feature-description',
            targetProductDetail: 'product-detail',
            errors: {},
            template: _.template(template),
            options: [],
            events: {
                'click .AknButton': 'addFieldBlock',
                'click .AknIconButton--ok': 'updateState'
            },

            /**
             * {@inheritdoc}
             */
            initialize: function (config) {
                this.config = config;

                BaseForm.prototype.initialize.apply(this, arguments);
            },

            /**
             * {@inheritdoc}
             */
            configure: function () {
                this.listenTo(
                    this.getRoot(),
                    'pim_enrich:form:entity:bad_request',
                    this.setValidationErrors.bind(this)
                );
                this.listenTo(
                    this.getRoot(),
                    'pim_enrich:form:entity:post_fetch',
                    this.resetValidationErrors.bind(this)
                );
                this.listenTo(this.getRoot(), 'pim_enrich:form:entity:post_fetch', this.render.bind(this));

                return BaseForm.prototype.configure.apply(this, arguments);
            },

            /**
             * Set the validation errors after validation fail
             *
             * @param {event} event
             */
            setValidationErrors: function (event) {
                this.errors = event.response;
            },

            /**
             * Rest validation error after fetch
             */
            resetValidationErrors: function () {
                this.errors = {};
            },

            /**
             * Get the validtion errors for the given field
             *
             * @param {string} field
             *
             * @return {mixed}
             */
            getValidationErrorsForField: function (field) {
                return propertyAccessor.accessProperty(this.errors, field, []);
            },

            /**
             * Renders this view.
             *
             * @return {Object}
             */
            render: function () {
                this.$el.html(this.template({__: __}));

                return this;
            },

            /**
             *
             * @param event
             */
            addFieldBlock: function (event) {
                let ctx = $(event.target);
                let target = ctx.attr('data-action-target');
                if (!target || (target !== this.targetFieldDescription && target !== this.targetProductDetail)) {
                    return;
                }
                let dropZone = $('*[data-drop-zone=grouped-' + target +']');
                if (!dropZone) {
                    return;
                }

                (true === (target === this.targetFieldDescription))
                    ? this.renderFeatureDescriptionBlock(dropZone)
                    : this.renderProductDetailsBlock(dropZone);

                this.delegateEvents();
            },

            /**
             * Sets new scope on field change.
             *
             * @param {Object} event
             */
            updateState: function (event) {

                console.log('update'); debugger;
                this.setScope(event.target.value);
            },

            /**
             * Sets specified scope into root model.
             *
             * @param {String} code
             */
            setScope: function (code) {
                var data = this.getConfiguration();
                var before = data.googleFeatureDescription;

                data.googleFeatureDescription = code;
                this.setData(data);
            },

            /**
             * Gets scope from root model.
             *
             * @returns {String}
             */
            getScope: function () {
                var configuration = this.getConfiguration();

                if (_.isUndefined(configuration)) {
                    return null;
                }

                return _.isUndefined(configuration.googleFeatureDescription) ? null : configuration.googleFeatureDescription;
            },

            /**
             * Get filters
             *
             * @return {object}
             */
            getConfiguration: function () {
                return this.getFormData().configuration;
            },

            /**
             * Get Description Block
             *
             * @param dropZone
             */
            renderFeatureDescriptionBlock: function(dropZone) {
                this.getAttributes().then(function (attributes) {
                    let block = new DndGoogleFeatureDescriptionBlock(this.getConfiguration());

                    dropZone.append(block.render(attributes));

                    initSelect2.init(this.$('input.select-field'), {
                        placeholder: 'pim_enrich.form.common.tab.attributes.btn.add_attributes',
                        title: 'pim_enrich.form.common.tab.attributes.info.search_attributes',
                        buttonTitle: 'pim_enrich.form.common.tab.attributes.btn.add',
                        countTitle: 'pim_enrich.form.product.tab.attributes.info.attributes_selected',
                        emptyText: 'pim_enrich.form.common.tab.attributes.info.no_available_attributes',
                        classes: 'pim-add-attributes-multiselect',
                        minimumInputLength: 0,
                        dropdownCssClass: 'add-attribute',
                        closeOnSelect: false,
                        query: this.onGetQuery.bind(this),
                        initSelection: this.initSelect.bind(this)
                    }).select2('val', attributes);

                }.bind(this));

                return this;
            },

            /**
             * Get Product Details Block
             *
             * @param dropZone
             */
            renderProductDetailsBlock: function(dropZone) {
                this.getAttributes().then(function (attributes) {
                    let block = new DndGoogleProductDetailBlock(this.getConfiguration());

                    dropZone.append(block.render(attributes));

                    initSelect2.init(this.$('input.select-field'), {
                        placeholder: 'pim_enrich.form.common.tab.attributes.btn.add_attributes',
                        title: 'pim_enrich.form.common.tab.attributes.info.search_attributes',
                        buttonTitle: 'pim_enrich.form.common.tab.attributes.btn.add',
                        countTitle: 'pim_enrich.form.product.tab.attributes.info.attributes_selected',
                        emptyText: 'pim_enrich.form.common.tab.attributes.info.no_available_attributes',
                        classes: 'pim-add-attributes-multiselect',
                        minimumInputLength: 0,
                        dropdownCssClass: 'add-attribute',
                        closeOnSelect: false,
                        query: this.onGetQuery.bind(this),
                        initSelection: this.initSelect.bind(this)
                    }).select2('val', attributes);
                }.bind(this));

                return this;
            },

            initSelect: function(element, callback) {
                this.getAttributes().then(function (attributes) {

                    callback(attributes);
                });
            },

            /**
             * Get Attributes
             *
             * @returns {object}
             */
            getAttributes: function() {
                return fetcherRegistry
                    .getFetcher('attributes-list')
                    .fetchAll();
            },

            onGetQuery: function(options) {
                return options;
            }
        });
    }
);
