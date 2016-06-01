<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Implements theme functions into eCommerce Product Catalog plugin.
 *
 * Created by Norbert Dreszer.
 * Date: 13-Feb-15
 * Time: 13:42
 * Package: frontend/functions
 */
function ic_modify_product_search_button_text( $text ) {
	return '';
}

add_filter( 'product_search_button_text', 'ic_modify_product_search_button_text' );
