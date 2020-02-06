'use strict';

define(['pim/form/common/delete', 'barcodes/remover/pricingrule'], function (DeleteForm, AttributeRemover) {
    return DeleteForm.extend({
        remover: AttributeRemover
    });
});
