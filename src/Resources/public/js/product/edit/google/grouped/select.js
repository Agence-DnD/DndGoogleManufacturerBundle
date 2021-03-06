'use strict';
/**
 * Override Akeneo Select2
 *
 * @author    Didier Youn <didier.youn@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
define(
    [
        'jquery',
        'underscore',
        'oro/translator',
        'pim/template/form/add-select/select',
        'pim/form',
        'pim/common/add-select/line',
        'pim/common/add-select/footer',
        'pim/user-context',
        'pim/fetcher-registry',
        'pim/formatter/choices/base',
        'oro/mediator',
        'pim/initselect2',
        'pim/i18n',
        'routing'
    ],
    function (
        $,
        _,
        __,
        template,
        BaseForm,
        LineView,
        FooterView,
        UserContext,
        FetcherRegistry,
        ChoicesFormatter,
        mediator,
        initSelect2,
        i18n,
        Routing
    ) {
        return BaseForm.extend({
            tagName: 'div',
            targetElement: 'input[type="hidden"]',
            className: null,
            mainFetcher: null,
            template: _.template(template),
            lineView: LineView,
            footerView: FooterView,
            config: {},
            resultsPerPage: null,
            selection: [],
            previousSelection: null,
            itemViews: [],
            footerViewInstance: null,
            queryTimer: null,
            addEvent: null,
            disableEvent: null,
            enableEvent: null,
            disabled: false,
            defaultConfig: {
                select2: {
                    placeholder: 'pim_enrich.form.common.base-add-select.btn.add',
                    countTitle: 'pim_enrich.form.common.base-add-select.label.select_count'
                },
                resultsPerPage: 10,
                searchParameters: {},
                mainFetcher: null,
                events: {
                    disable: null,
                    enable: null,
                    add: null
                }
            },

            /**
             * {@inheritdoc}
             */
            initialize: function (meta) {
                this.config = $.extend(true, {}, this.defaultConfig, meta.config);

                if (_.isNull(this.config.mainFetcher)) {
                    throw new Error('Fetcher code must be provided in config');
                }

                this.config.select2.placeholder = __(this.config.select2.placeholder);
                this.config.select2.title       = __(this.config.select2.title);
                this.config.select2.buttonTitle = __(this.config.select2.buttonTitle);
                this.config.select2.emptyText   = __(this.config.select2.emptyText);

                this.resultsPerPage = this.config.resultsPerPage;
                this.mainFetcher    = this.config.mainFetcher;
                this.className      = this.config.className;

                this.disableEvent = this.config.events.disable;
                this.enableEvent  = this.config.events.enable;
                this.addEvent     = this.config.events.add;
            },

            /**
             * {@inheritdoc}
             */
            configure: function () {
                if (!_.isNull(this.enableEvent) && !_.isNull(this.disableEvent)) {
                    mediator.on(
                        this.disableEvent,
                        this.onDisable.bind(this)
                    );

                    mediator.on(
                        this.enableEvent,
                        this.onEnable.bind(this)
                    );
                }

                return BaseForm.prototype.configure.apply(this, arguments);
            },

            /**
             * Render this extension
             *
             * @return {Object}
             */
            render: function () {
                this.$el.html(this.template());

                $('input[type="hidden"].select-field').prop('readonly', this.disabled);

                this.initializeSelectWidget();
                this.delegateEvents();

                return this;
            },

            /**
             * Initialize select2 and format elements.
             */
            initializeSelectWidget: function () {
                var $multiSelect = $('input[type="hidden"].select-field.select-multi-field.on-initialize');
                var $singleSelect = $('input[type="hidden"].select-field.select-single-field.on-initialize');

                $multiSelect = initSelect2.init($multiSelect, this.getMultiSelectConfig());
                $singleSelect = initSelect2.init($singleSelect, this.getSingleSelectConfig());

                mediator.once('hash_navigation_request:start', function () {
                    $multiSelect.select2('close');
                    $multiSelect.select2('destroy');

                    $singleSelect.select2('close');
                    $singleSelect.select2('destroy');
                });

                $multiSelect.on('select2-selecting', this.onSelecting.bind(this));
                $multiSelect.on('select2-open', this.onSelectOpen.bind(this));
                $multiSelect.on('select2-close', this.onSelectClose.bind(this));

                $singleSelect.on('select2-selecting', this.onSelecting.bind(this));
                $singleSelect.on('select2-open', this.onSelectOpen.bind(this));
                $singleSelect.on('select2-close', this.onSelectClose.bind(this));

                this.footerViewInstance = new this.footerView({
                    buttonTitle: this.config.select2.buttonTitle,
                    countTitle: this.config.select2.countTitle,
                    addEvent: this.addEvent
                });

                this.footerViewInstance.on(this.addEvent, function () {
                    $multiSelect.select2('close');
                    if (0 < this.selection.length) {
                        this.addItems();
                    }
                }.bind(this));

                var $menu = this.$('.select2-drop');
                $menu.append(this.footerViewInstance.render().$el);

                this.initializeLabel($multiSelect);
                this.initializeLabel($singleSelect);
            },

            /**
             * Init labels after render
             *
             * @param {Object} selects
             */
            initializeLabel: function(selects) {
                $.each(selects, function (i, select) {
                    if (!select) {
                        return;
                    }
                    select = $(select);
                    select = $(select[0]);
                    if (select.hasClass('on-initialize')) {
                        let gValues = select.attr('data-google-value');
                        if (gValues && !_.isUndefined(gValues) && gValues !== '') {
                            this.refreshLabel(select);
                        }
                        select.addClass('is-enriched');
                    }
                }.bind(this));
            },

            /**
             * Triggers configured event with items codes selected
             */
            addItems: function () {
                this.getRoot().trigger(this.addEvent, { codes: this.selection });
            },

            /**
             * Gets search parameters
             *
             * @param {string} term
             * @param {int}    page
             *
             * @return {Object}
             */
            getSelectSearchParameters: function (term, page) {
                return $.extend(true, {}, this.config.searchParameters, {
                    search: term,
                    options: {
                        limit: this.resultsPerPage,
                        page: page,
                        locale: UserContext.get('uiLocale')
                    }
                });
            },

            /**
             * Gets items to exclude
             *
             * @return {Promise}
             */
            getItemsToExclude: function () {
                return $.Deferred().resolve([]);
            },

            /**
             * @param {Object} items
             *
             * @return {Object}
             */
            prepareChoices: function (items) {
                return _.chain(_.sortBy(items, function (item) {
                    return item.sort_order;
                })).map(function (item) {
                    return ChoicesFormatter.formatOne(item);
                }).value();
            },

            /**
             * Formats and updates list of items
             *
             * @param {Object} item
             *
             * @return {Object}
             */
            onGetResult: function (item) {
                var line = _.findWhere(this.itemViews, {itemCode: item.id});

                if (_.isUndefined(line) || _.isNull(line)) {
                    line = {
                        itemCode: item.id,
                        itemView: new this.lineView({
                            checked: _.contains(this.selection, item.id),
                            item: item
                        })
                    };

                    this.itemViews.push(line);
                }

                return line.itemView.render().$el;
            },

            /**
             * Creates request according to recieved options
             *
             * @param {Object} options
             */
            onGetQuery: function (options) {
                clearTimeout(this.queryTimer);
                this.queryTimer = setTimeout(function () {
                    var page = 1;
                    if (options.context && options.context.page) {
                        page = options.context.page;
                    }
                    var searchParameters = this.getSelectSearchParameters(options.term, page);

                    this.fetchItems(searchParameters)
                        .then(function (items) {
                            var choices = this.prepareChoices(items);

                            options.callback({
                                results: choices,
                                more: choices.length === this.resultsPerPage,
                                context: {
                                    page: page + 1
                                }
                            });
                        }.bind(this));
                }.bind(this), 400);
            },

            /**
             * Fetches items from the backend.
             *
             * @param {Object} searchParameters
             *
             * @return {Promise}
             */
            fetchItems: function (searchParameters) {
                return this.getItemsToExclude()
                    .then(function (identifiersToExclude) {
                        searchParameters.options.excluded_identifiers = identifiersToExclude;

                        return FetcherRegistry.getFetcher(this.mainFetcher).search(searchParameters);
                    }.bind(this));
            },

            /**
             * Intercepts default select2 selecting event and handles it
             *
             * @param {Object} event
             */
            onSelecting: function (event) {
                var item = $(event.target);
                var itemCode = event.val;

                if (item.hasClass('select-single-field')) {
                    this.selection = [itemCode];
                } else {
                    var alreadySelected = _.contains(this.selection, itemCode);
                    if (alreadySelected) {
                        this.selection = _.without(this.selection, itemCode);
                    } else {
                        this.selection.push(itemCode);
                    }
                }
                var line = _.findWhere(this.itemViews, {itemCode: itemCode});
                if (line) {
                    line.itemView.setCheckedCheckbox(!alreadySelected);
                }
                this.updateSelectedCounter(item);

                event.preventDefault();
            },

            /**
             * Cleans select2 when open
             */
            onSelectOpen: function (event) {
                let item = $(event.target);

                this.selection = [];
                this.itemViews = [];
                this.previousSelection = item.attr('data-google-value') ? item.attr('data-google-value') : '';

                this.updateSelectedCounter();
            },

            /**
             * Change state if needed
             */
            onSelectClose: function (event) {
                let item = $(event.target);
                let selection = item.attr('data-google-value') ? item.attr('data-google-value') : '';
                if (selection === this.previousSelection) {
                    return;
                }
                let parent = item.parent().parent().parent();
                let state = parent.find('.AknTitleContainer-state');
                if (state && state.is(':hidden')) {
                    state.fadeIn(300);
                }
            },

            /**
             * Update counter of selected items
             */
            updateSelectedCounter: function (item) {
                if (!item) {
                    return;
                }
                if (item.hasClass('on-initialize')) {
                    item.removeClass('on-initialize');
                }
                let itemContainer = item.parent();
                if (!itemContainer) {
                    return;
                }
                let input = itemContainer.find('input[type=hidden]');
                if (_.isEmpty(this.selection)) {
                    return;
                }
                input.attr('data-google-value', this.selection.join());
                input.addClass('is-enriched');

                this.removeError(input);
                this.refreshLabel(input);
            },

            removeError: function(input) {
                let itemContainer = input.closest('.AknFieldContainer');
                let error = itemContainer.find('.AknFieldContainer-footer > .below-input-elements-container');
                if (error) {
                    error.each(function () {
                        $(this).empty();
                    });
                }
            },

            refreshLabel: function(input) {
                let values = input.attr('data-google-value');
                if (!values) {
                    return;
                }
                values = values.split(',');
                let itemContainer = input.parent();
                if (!itemContainer) {
                    return;
                }
                let chosen = itemContainer.find('.select2-chosen');
                if (!chosen) {
                    return;
                }
                chosen
                    .html(values.map(function(code) {
                        code = code.replace(/_(\w{1})/, function(a, b) {
                            return ' ' + b.toUpperCase();
                        });

                        return code.charAt(0).toUpperCase() + code.slice(1);
                    }).join(' - '))
                    .addClass('is-enriched');
            },

            /**
             * Disable callback
             */
            onDisable: function () {
                this.disabled = true;
                this.render();
            },

            /**
             * Enable callback
             */
            onEnable: function () {
                this.disabled = false;
                this.render();
            },

            getMultiSelectConfig: function () {
                return $.extend(true, {}, this.config.select2, {
                    dropdownCssClass: 'select2--bigDrop select2--annotedLabels ' + this.config.select2.dropdownCssClass,
                    formatResult: this.onGetResult.bind(this),
                    query: this.onGetQuery.bind(this)
                });
            },

            getSingleSelectConfig: function () {
                return {
                    allowClear: true,
                    ajax: {
                        url: Routing.generate('pim_enrich_attribute_rest_index'),
                        quietMillis: 250,
                        cache: true,
                        data: function (term, page) {
                            return {
                                search: term,
                                options: {
                                    limit: 20,
                                    page: page,
                                    locale: UserContext.get('catalogLocale')
                                }
                            };
                        },
                        results: function (attributes) {
                            var data = {
                                more: 20 === _.keys(attributes).length,
                                results: []
                            };
                            _.each(attributes, function (value, key) {
                                data.results.push({
                                    id: value.code,
                                    text: i18n.getLabel(
                                        value.labels,
                                        UserContext.get('catalogLocale'),
                                        value.code
                                    )
                                });
                            });

                            return data;
                        }
                    }
                }
            }
        });
    }
);

