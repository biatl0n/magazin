<?php

/**
 * Manages css functions
 *
 * Here css functions are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend/css
 * @author 		Norbert Dreszer
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function button_background_color( $option, $hover = null ) {
	$color = '';
	if ( $option == 'red' && $hover != 1 ) {
		$color = 'linear-gradient(to bottom, #A70202 0%, #8B0000 100%) repeat scroll 0% 0% transparent';
	} else if ( $option == 'red' && $hover == 1 ) {
		$color = 'linear-gradient(to bottom, #8B0000 0%, #7D0000 100%) repeat scroll 0% 0% transparent';
	} else if ( $hover != 1 ) {
		$color = 'linear-gradient(to bottom, ' . $option . ' 0%, ' . adjustBrightness( $option, -12 ) . ' 100%) repeat scroll 0% 0% transparent';
	} else {
		$color = 'linear-gradient(to bottom, ' . $option . ' 0%, ' . adjustBrightness( $option, -22 ) . ' 100%) repeat scroll 0% 0% transparent';
	}

	echo $color;
}

function button_border_color( $option ) {
	$color = '';
	if ( $option == 'red' ) {
		$color = '#7D0000';
	} else {
		$color = $option;
	}

	echo $color;
}

function adjustBrightness( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );

	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values
	$r	 = hexdec( substr( $hex, 0, 2 ) );
	$g	 = hexdec( substr( $hex, 2, 2 ) );
	$b	 = hexdec( substr( $hex, 4, 2 ) );

	// Adjust number of steps and keep it inside 0 to 255
	$r	 = max( 0, min( 255, $r + $steps ) );
	$g	 = max( 0, min( 255, $g + $steps ) );
	$b	 = max( 0, min( 255, $b + $steps ) );

	$r_hex	 = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex	 = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex	 = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}
