(function($) {
    // Add a refresh action for the combobox facet
    FWP.hooks.addAction('facetwp/refresh/combobox', function($this, facet_name) {
        var val = $this.find('.facetwp-combobox').val();
        FWP.facets[facet_name] = val ? [val] : [];
    });

    // Add a filter for the combobox facet selections
    FWP.hooks.addFilter('facetwp/selections/combobox', function(output, params) {
        var $item = params.el.find('.facetwp-combobox');
        if ($item.len()) {
            var dd = $item.nodes[0];
            var text = dd.options[dd.selectedIndex].text;
            return text.replace(/\(\d+\)$/, '');
        }
        return '';
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
		$('.ui.dropdown').dropdown();
    });
})(jQuery);