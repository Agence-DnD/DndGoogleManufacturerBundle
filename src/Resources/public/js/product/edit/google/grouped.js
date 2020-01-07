'use strict';
/**
 * Grouped structure
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2020 Agence Dn'D
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
        'dnd/common/add-select',
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
        BaseAddSelect,
    ) {
        return BaseForm.extend({
            targetFieldDescription: 'feature-description',
            targetProductDetail: 'product-detail',
            errors: {},
            template: _.template(template),
            options: [],
            events: {
                'click .AknButton': 'addFieldBlock',
                'click .AknIconButton--ok': 'updateState',
                'click .AknIconButton--editWhite': 'updateState',
                'click .AknIconButton--removeWhite': 'removeState'
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
                this.listenTo(this.getRoot(), 'pim_enrich:form:entity:post_fetch', this.onPostFetch);

                return BaseForm.prototype.configure.apply(this, arguments);
            },

            /**
             * Triggered post fetch
             */
            onPostFetch: function() {
                this.render.bind(this);
            },

            /**
             * Set the validation errors after validation fail
             */
            initializeGroupedAttributes: function() {
                let config = this.getConfiguration();

                [this.targetFieldDescription, this.targetProductDetail].map(function (attribute) {
                    let dropZone = $('*[data-drop-zone=grouped-' + attribute +']');
                    let gAttribute = 'googleProductDetail';
                    if (true === (attribute === this.targetFieldDescription)) {
                        gAttribute = 'googleFeatureDescription';
                    }
                    let gData = (false === _.has(config, gAttribute) || (true === _.has(config, gAttribute) && true === _.isUndefined(config[gAttribute])))
                        ? []
                        : config[gAttribute]
                    ;
                    if (gData) {
                        for (let key in gData) {
                            if (_.isNull(gData[key])) {
                                continue;
                            }
                            if (true === (attribute === this.targetFieldDescription)) {
                                this.renderFeatureDescriptionBlock(dropZone, key);
                            } else {
                                this.renderProductDetailsBlock(dropZone, key);
                            }
                        }
                    }
                }, this);
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
                if (!this.configured) {
                    return this;
                }
                this.$el.html(this.template({__: __}));

                this.initializeGroupedAttributes();
                this.renderExtensions();
                this.delegateEvents();

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

                let blocks = $('.google-grouped-' + target);
                let blockId = (blocks && blocks.length) ? blocks.length + 1 : 1;

                (true === (target === this.targetFieldDescription))
                    ? this.renderFeatureDescriptionBlock(dropZone, blockId)
                    : this.renderProductDetailsBlock(dropZone, blockId);

                this.delegateEvents();
            },

            /**
             * Sets new scope on field change.
             *
             * @param {Object} event
             */
            updateState: function (event) {
                let ctx = $(event.target);
                let ctxBlock = ctx.closest('div.AknFieldContainer');
                let inputs = ctxBlock.find('input.is-enriched');

                let gBlock = ctxBlock.children().first();
                let gBlockType = gBlock.attr('data-block');
                let gBlockId = gBlock.attr('data-block-id');

                let options = {};

                inputs.each(function ()  {
                    let input = $(this);
                    if (!input) {
                        return;
                    }
                    input = $(input[0]);
                    let codes = input.attr('data-google-value');
                    if (!codes) return;
                    codes = codes.split(',');
                    let gAttr = input.attr('data-google');
                    if (!gAttr) return;

                    options[gAttr] = codes;
                });

                this.afterUpdate(gBlockType, options, ctx);
            },

            /**
             * Sets new scope on field change.
             *
             * @param {Object} event
             */
            removeState: function (event) {
                let ctx = $(event.target);
                let ctxBlock = ctx.closest('div.AknFieldContainer');

                let gBlock = ctxBlock.children().first();
                let gBlockType = gBlock.attr('data-block');
                let gBlockId = gBlock.attr('data-block-id');

                let data = this.getConfiguration();

                if (true === _.has(data, gBlockType) && true === _.has(data[gBlockType], gBlockId)) {
                    let gData = data[gBlockType];
                    data[gBlockType] = _.omit(gData, gBlockId);

                    this.setData(data);
                }

                ctxBlock.remove();
            },

            /**
             * Sets specified scope into root model.
             *
             * @param {String} gAttrCode
             * @param {Object} options
             */
            setScope: function (gAttrCode, options) {
                var data = this.getConfiguration();
                if (_.isUndefined(data[gAttrCode]) || _.isNull(data[gAttrCode])) {
                    data[gAttrCode] = options
                } else {
                    $.extend(true,  data[gAttrCode], options)
                }

                this.setData(data);
            },

            /**
             * Gets scope from root model.
             *
             * @returns Object
             */
            getScope: function () {
                var configuration = this.getConfiguration();
                if (_.isUndefined(configuration)) {
                    return {};
                }

                return configuration;
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
             * Get config for select
             *
             * @return {object}
             */
            getSelectConfiguration: function () {
                return {
                    select2: {
                        placeholder: 'pim_common.add_attributes',
                        title: 'pim_common.select2.search',
                        buttonTitle: 'pim_common.add',
                        countTitle: 'pim_enrich.entity.attribute.module.add_attribute.attributes_selected',
                        emptyText: 'pim_enrich.entity.attribute.module.add_attribute.no_available_attributes',
                        classes: 'pim-add-attributes-multiselect',
                        minimumInputLength: 0,
                        dropdownCssClass: 'add-attribute',
                        closeOnSelect: false
                    },
                    resultsPerPage: 10,
                    searchParameters: {options: {}},
                    mainFetcher: 'attribute'
                };
            },

            /**
             * Get Description Block
             *
             * @param dropZone
             * @param blockId
             */
            renderFeatureDescriptionBlock: function(dropZone, blockId) {
                let block = new DndGoogleFeatureDescriptionBlock(
                    $.extend(true, { events: {}}, this.getConfiguration(), {
                            blockId: blockId
                        }
                    )
                );
                dropZone.prepend(block.render());

                let opts = $.extend(true, { events: {}}, this.getSelectConfiguration(), this.config);
                let select = new BaseAddSelect({
                    config: opts
                });
                select.render();

                return this;
            },

            /**
             * Get Product Details Block
             *
             * @param dropZone
             * @param blockId
             */
            renderProductDetailsBlock: function(dropZone, blockId) {
                let block = new DndGoogleProductDetailBlock(
                    $.extend(true, {}, this.getConfiguration(), {
                            blockId: blockId
                        }
                    )
                );
                dropZone.prepend(block.render());

                let opts = $.extend(true, {}, this.getSelectConfiguration(), this.config);
                let select = new BaseAddSelect({
                    config: opts
                });
                select.render().bind();

                return this;
            },

            /**
             * Check if the grouped attributes is filled by mandatory attributes
             *
             * @param type
             * @param options
             * @param elem
             */
            afterUpdate: function(type, options, elem) {
                let errors = [];
                let ctxBlock = elem.closest('div.AknFieldContainer');
                let inputs = ctxBlock.find('input');

                let gBlock = ctxBlock.children().first();
                let gBlockType = gBlock.attr('data-block');
                let gBlockId = gBlock.attr('data-block-id');

                return fetcherRegistry.getFetcher('google-grouped-attribute').fetch(type)
                    .then((requirements) => {
                        if (_.isEmpty(requirements)) {
                            return;
                        }
                        requirements.forEach(function (requirement) {
                            if (!options.hasOwnProperty(requirement)) {
                                errors.push(requirement);
                            }
                        });
                        if (errors.length >= 1 || !_.isEmpty(errors)) {
                            // Clean previous errors
                            let oldErrors = ctxBlock.find('.AknFieldContainer-footer > .below-input-elements-container');
                            if (oldErrors) {
                                oldErrors.each(function (error) {
                                    $(this).html();
                                });
                            }
                            for (let error in errors) {
                                let input = ctxBlock.find(`[data-google='${errors[error]}']`);
                                if (input) {
                                    let parent = input.closest('.AknFieldContainer');
                                    let footer = parent.find('.AknFieldContainer-footer');
                                    if (footer) {
                                        let errorsBlock = footer.find('.below-input-elements-container');
                                        errorsBlock.empty().append(this.addError())
                                    }
                                }
                            }
                        } else {
                            if (Object.keys(options).length >= 1) {
                                this.setScope(gBlockType, {
                                    [gBlockId]: options
                                });
                                if (elem.hasClass('AknIconButton--ok')) {
                                    elem.removeClass('AknIconButton--ok').addClass('AknIconButton--editWhite');
                                }
                            }
                            let parent = ctxBlock.parent();
                            let state = parent.find('.AknTitleContainer-state');
                            if (state && state.is(':visible')) {
                                state.fadeOut(300);
                            }
                        }
                    });
            },

            addError: function () {
                let msg = __('dnd_google_manufacturer.export.product.google.grouped.error');

                return `
                    <span class="validation-container">
                        <span class="AknFieldContainer-validationErrors validation-errors">
                            <span class="AknFieldContainer-validationError">
                                <i class="icon-warning-sign"></i> <span class="error-message">${msg}</span>
                            </span>
                        </span>
                    </span>
                `;
            }
        });
    }
);
