jQuery(document).ready(function () {

    /* Save taxonomy */
    jQuery('html').delegate('.media-terms input', 'change', function () {

        var obj = jQuery(this),
            container = obj.parents('.media-terms'),
            row = container.parent(),
            data = {
                action: 'save-media-terms',
                term_ids: [],
                attachment_id: container.data('id'),
                taxonomy: container.data('taxonomy')
            };

        container.find('input:checked').each(function () {
            data.term_ids.push(jQuery(this).val());
        });

        row.addClass('media-save-terms');
        container.find('input').prop('disabled', 'disabled');

        jQuery.post(ajaxurl, data, function (response) {
            row.removeClass('media-save-terms');
            container.find('input').removeProp('disabled');
        });

    });

    // Add new taxonomy
    jQuery('html').delegate('.toggle-add-media-term', 'click', function (e) {
        e.preventDefault();
        jQuery(this).parent().find('.add-new-term').toggle();
    });

    // Save new taxnomy
    jQuery('html').delegate('.save-media-term', 'click', function (e) {

        var obj = jQuery(this),
            termField = obj.parent().find('input'),
            termParent = obj.parent().find('select'),
            data = {
                action: 'add-media-term',
                attachment_id: obj.data('id'),
                taxonomy: obj.data('taxonomy'),
                parent: termParent.val(),
                term: termField.val()
            };

        // No val
        if ('' == data.term) {
            termField.focus();
            return;
        }

        jQuery.post(ajaxurl, data, function (response) {

            obj.parents('.field').find('.media-terms ul:first').html(response.checkboxes);
            obj.parents('.field').find('select').replaceWith(response.selectbox);

            console.log(response);

            termField.val('');

        }, 'json');

    });

});
