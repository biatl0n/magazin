<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme content functions
 *
 * Here theme content functions are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend/functions
 * @author 		Norbert Dreszer
 */
function ic_content_settings() {
	$options						 = ic_default_content_settings();
	$options[ 'product_sidebar' ]	 = get_theme_mod( 'ic_product_sidebar', $options[ 'product_sidebar' ] );
	return apply_filters( 'ic_content_settings', $options );
}

function ic_default_content_settings() {
	$default = array(
		'product_sidebar' => 1,
	);
	return $default;
}

add_action( 'widgets_init', 'ic_product_sidebar' );

function ic_product_sidebar() {
	$content_settings = ic_content_settings();
	if ( function_exists( 'impleCode_EPC' ) && isset( $content_settings[ 'product_sidebar' ] ) ? $content_settings[ 'product_sidebar' ] : '' == 1 ) {
		register_sidebar( array(
			'name'			 => __( 'Product Sidebar', 'catalog-me' ),
			'id'			 => 'product-sidebar',
			'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'	 => '</aside>',
			'before_title'	 => '<h3 class="widget-title">',
			'after_title'	 => '</h3>',
		) );
	}
}
