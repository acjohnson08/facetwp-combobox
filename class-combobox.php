<?php

class FacetWP_Facet_Combobox extends FacetWP_Facet
{

    function __construct() {
    $this->label = __( 'Combobox', 'fwp' );
    $this->fields = [ 'label_any', 'parent_term', 'modifiers', 'hierarchical', 'multiple',
        'ghosts', 'operator', 'orderby', 'count' ];

    if ( !is_admin() ) {
        // Enqueue Semantic UI CSS and JavaScript files
        wp_enqueue_style( 'semantic-ui-css', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css', array(), '2.4.1' );
        wp_enqueue_script( 'semantic-ui-js', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js', array('jquery'), '2.4.1', true );
    }
}


    /**
     * Load the available choices
     */
    function load_values( $params ) {
    $values = FWP()->helper->facet_types['checkboxes']->load_values( $params );

    // Remove empty options
    $values = array_filter($values, function($value) {
        return !empty($value['facet_value']) && !empty($value['facet_display_value']);
    });

    return $values;
}

	
	 /**
     * Generate the facet HTML
     */
    function render( $params ) {
		
		$output = '';
		$facet = $params['facet'];
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];
		$is_hierarchical = FWP()->helper->facet_is( $facet, 'hierarchical', 'yes' );
		$multiple = FWP()->helper->facet_is( $facet, 'multiple', 'yes' ) ? 'multiple' : '';
		$search = FWP()->helper->facet_is( $facet, 'multiple', 'yes' ) ? 'multiple search selection' : 'search selection';
		$class = 'ui fluid ' . $search . ' dropdown';
		
		if ( $is_hierarchical ) {
			$class .= ' hierarchical';
		}
		
		$output .= '<div class="' . $class . '">';
		$output .= '<input class="facetwp-combobox" type="hidden" name="' . $facet['name'] . '">';
		$output .= '<i class="dropdown icon"></i>';
		$output .= '<div class="default text">' . esc_html( $facet['label_any'] ) . '</div>';
		$output .= '<div class="menu">';
		
		foreach ( $values as $row ) {
			$selected = in_array( $row['facet_value'], $selected_values ) ? ' selected' : '';
			$indent = $is_hierarchical ? str_repeat( '&nbsp;&nbsp;', (int) $row['depth'] ) : '';
			
			$label = esc_html( $row['facet_display_value'] );
			$label = apply_filters( 'facetwp_facet_display_value', $label, [
				'selected' => ( '' !== $selected ),
				'facet' => $facet,
				'row' => $row
			]);
			
			$show_counts = apply_filters( 'facetwp_facet_dropdown_show_counts', true, [ 'facet' => $facet ] );
			
			if ( $show_counts ) {
				$label .= ' (' . $row['counter'] . ')';
			}
			
			$output .= '<div class="item" data-value="' . esc_attr( $row['facet_value'] ) . '" '.$selected.'>' . $indent . $label . '</div>';
		}
		
		$output .= '</div></div>';
		return $output;
}
	
	
    /**
     * Load the necessary front-end script(s) for handling user interactions
     */
    function front_scripts() {
        FWP()->display->assets['combobox-front.js'] = plugins_url( '', __FILE__ ) . '/assets/js/front.js';
    }
	
	
    /**
     * Filter the query based on selected values
     */
    function filter_posts( $params ) {
        return FWP()->helper->facet_types['checkboxes']->filter_posts( $params );
    }


}