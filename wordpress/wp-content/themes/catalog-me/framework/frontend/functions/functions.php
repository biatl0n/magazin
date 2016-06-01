<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages theme frontend functions
 *
 * Here theme general settings are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend/functions
 * @author 		Norbert Dreszer
 */
if ( !function_exists( 'check_permalink_options_update' ) ) {

	function check_permalink_options_update() {
		$options_update = get_option( 'al_permalink_options_update', 'none' );
		if ( $options_update != 'none' ) {
			flush_rewrite_rules( false );
			update_option( 'al_permalink_options_update', 'none' );
		}
	}

}
add_action( 'init', 'check_permalink_options_update', 99 );

if ( !function_exists( 'echo_ic_setting' ) && !defined( 'AL_BASE_PATH' ) ) {

	function echo_ic_setting( $return, $echo = 1 ) {
		if ( $echo == 1 ) {
			echo $return;
		}
		return $return;
	}

}

function implecode_paging_nav() {
	if ( is_singular() )
		return;
	global $wp_query;
	if ( $wp_query->max_num_pages <= 1 )
		return;
	$paged	 = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max	 = intval( $wp_query->max_num_pages );
	if ( $paged >= 1 )
		$links[] = $paged;
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}
	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}
	echo '<div id="product_archive_nav" class="archive-nav"><ul>' . "\n";
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link() );
	if ( !in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ) . '#product_archive_nav', '1' );
		if ( !in_array( 2, $links ) )
			echo '<li>...</li>';
	}
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ) . '#product_archive_nav', $link );
	}
	if ( !in_array( $max, $links ) ) {
		if ( !in_array( $max - 1, $links ) )
			echo '<li>...</li>' . "\n";
		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ) . '#product_archive_nav', $max );
	}
	if ( get_next_posts_link() ) {
		printf( '<li>%s</li>' . "\n", get_next_posts_link() );
	}
	echo '</ul></div>' . "\n";

	wp_reset_postdata();
}

if ( !function_exists( 'create_ic_overlay' ) ) {

	function create_ic_overlay() {
		echo '<div id="ic_overlay" style="display:none"></div>';
	}

	add_action( 'wp_footer', 'create_ic_overlay' );
}

function ic_change_theme_style() {
	update_option( 'ic_theme_style_changed', 1 );
}

add_action( 'implecode-settings-content', 'ic_change_theme_style' );

function ic_theme_style_changed() {
	$changed = get_option( 'ic_theme_style_changed', 0 );
	if ( $changed == 1 ) {
		return true;
	}
	return false;
}
