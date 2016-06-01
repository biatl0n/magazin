<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme branding
 *
 * Here theme branding is defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend
 * @author 		Norbert Dreszer
 */
function ic_theme_general_settings() {
	$options					 = ic_default_general_settings();
	$options[ 'phone_number' ]	 = get_theme_mod( 'ic_phone_number', $options[ 'phone_number' ] );
	$options[ 'email_address' ]	 = get_theme_mod( 'ic_email_address', $options[ 'email_address' ] );
	$options[ 'favicon' ]		 = get_theme_mod( 'ic_favicon', $options[ 'favicon' ] );
	$options[ 'marker' ]		 = !empty( $options[ 'marker' ] ) ? $options[ 'marker' ] : IC_FRAMEWORK_FOLDER . '/img/map-marker.png';
	return $options;
}

function ic_default_general_settings() {
	$default = array(
		'phone_number'	 => '555-555-555',
		'email_address'	 => 'example@example.com',
		'name'			 => 'impleCode',
		'favicon'		 => IC_FRAMEWORK_FOLDER . '/img/favicon.png',
	);
	return $default;
}

function ic_get_company_name() {
	$settings = ic_theme_general_settings();
	return $settings[ 'name' ];
}

add_action( 'wp_head', 'ic_add_favicon', 1 );

function ic_add_favicon() {
	$options = ic_theme_general_settings();
	if ( (!function_exists( 'has_site_icon' ) || !has_site_icon()) && $options[ 'favicon' ] != '' ) {
		echo '<link rel="shortcut icon" href="' . $options[ 'favicon' ] . '" type="image/x-icon">';
		echo '<link rel="icon" href="' . $options[ 'favicon' ] . '" type="image/x-icon">';
	}
}
