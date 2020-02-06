'use strict';
define(
    [
        'underscore',
        'oro/translator',
        'pim/controller/front',
        'pim/form-builder',
        'pim/fetcher-registry',
        'pim/user-context',
        'pim/dialog',
        'pim/page-title',
        'pim/i18n'
    ],
    function (_, __, BaseController, FormBuilder, FetcherRegistry, UserContext, Dialog, PageTitle, i18n) {
        return BaseController.extend({
            renderForm: function (route) {
                FetcherRegistry.getFetcher('locale').clear();
                /*console.log(route.params);*/
                if (undefined === route.params.id) {
                    var label = 'pim_enrich.entity.pricingrule.label.create';

                    return createForm.call(
                        this,
                        this.$el,
                        {
                            'code': '',
                            'meta': {}
                        },
                        label,
                        'barcodes-pricingrules-create-modal'
                    );
                } else {
                    /*console.log(FetcherRegistry);*/
                    console.log(FetcherRegistry.getFetcher('pricingrule'));
                    return FetcherRegistry.getFetcher('pricingrule')
                        .fetch(route.params.id, {cached: false, 'filter_locales': 0})
                        .then((pricingrule) => {
                            console.log(pricingrule);
                            var label = 'pim_enrich.entity.pricingrule.label.edit';
                            return createForm.call(this, this.$el, pricingrule, label, 'barcodes-pricingrules-edit');
                        });
                }

                function createForm(domElement, pricingrule, label, formExtension) {
                    PageTitle.set({'pricingrule.label': _.escape(label)});
                    return FormBuilder.build(formExtension)
                        .then((form) => {
                            this.on('pim:controller:can-leave', function (event) {
                                form.trigger('pim_enrich:form:can-leave', event);
                            });
                            form.setData(pricingrule);
                            form.trigger('pim_enrich:form:entity:post_fetch', pricingrule);
                            form.setElement(domElement).render();

                            return form;
                        });
                }
            }
        });
    }
);
/* Old Code */
/*define(['underscore','pim/controller/front', 'pim/form-builder'],
    function (_,BaseController, FormBuilder) {
        return BaseController.extend({
        	initialize: function (options) {
                this.options = options;
            },
            renderForm: function (route) {
                console.log(route.params);
                return FormBuilder.build('barcodes-pricingrules-edit').then((form) => {
                    form.setElement(this.$el).render();
                    return form;
                });
            }
        });
    }
);*/