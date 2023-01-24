<?php
/*
Plugin Name: FacetWP - Combobox
Description: Combobox facet type
Version: 0.1
Author: Andrew Johnson
Author URI: https://www.nystromcounseling.com
*/

defined( 'ABSPATH' ) or exit;

add_filter( 'facetwp_facet_types', function( $types ) {
    include( dirname( __FILE__ ) . '/class-combobox.php' );
    $types['combobox'] = new FacetWP_Facet_Combobox();
    return $types;
});