<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Defines theme activation functons
 *
 * Created: Mar 17, 2015
 * Package: activation
 */

add_action( "after_switch_theme", "implecode_business_activation" );

function implecode_business_activation() {
	ic_change_theme_style();
}
