<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme footer functions
 *
 * Here theme footer functions are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend/functions
 * @author 		Norbert Dreszer
 */
function ic_footer_settings() {
	$options = ic_default_footer_settings();
	return apply_filters( 'ic_footer_settings', $options );
}

function ic_default_footer_settings() {
	$default = array(
		'footer_copyright_note'		 => '© ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ),
		'footer_copyright_url'		 => 'http://implecode.com',
		'footer_copyright_url_name'	 => 'impleCode',
	);
	return $default;
}

add_action( 'implecode_credits', 'ic_set_footer_copyright' );

function ic_set_footer_copyright() {
	$set = ic_footer_settings();
	echo '<div class="credit"><span class="site-owner">' . $set[ 'footer_copyright_note' ] . '</span><a class="website-author" href="' . $set[ 'footer_copyright_url' ] . '">Catalog Me! by ' . $set[ 'footer_copyright_url_name' ] . '</a></div>';
}
