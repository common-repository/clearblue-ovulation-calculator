(function ($, window, document, undefined) { 'use strict';

    $('#cboc-admin .cb-color-picker').spectrum({
    	type: 'component',
    	showPalette: false,
    	showAlpha: false,
    	showButtons: false,
    	allowEmpty: false,
    	preferredFormat: 'hex'
    });

    $('#cboc-admin input[name="cb-submit-reset"]').on('click', function(e) {
    	var text = $(this).val();

    	return confirm(text + ' ?');
    });

})(jQuery, window, document);
