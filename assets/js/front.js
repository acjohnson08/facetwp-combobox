(function($) {
    // Add a refresh action for the combobox facet
    FWP.hooks.addAction('facetwp/refresh/combobox', function($this, facet_name) {
        var val = $this.find('.facetwp-combobox').val();
        FWP.facets[facet_name] = val ? [val] : [];
    });
    
	$(document).on('change', '.facetwp-type-combobox input[type="hidden"]', function() {
        var $facet = $(this).closest('.facetwp-facet');
        var facet_name = $facet.attr('data-name');

        if ('' !== $(this).val()) {
            FWP.frozen_facets[facet_name] = 'soft';
        }
        FWP.autoload();
    });
})(fUtil);

(function($) {
    $(document).on('facetwp-loaded', function() {
		$('.ui.dropdown').dropdown({forceSelection: false});
    });
})(jQuery);
