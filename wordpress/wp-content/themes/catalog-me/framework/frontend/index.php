<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages theme frontend
 *
 * Here theme frontend is defined and managed.
 *
 * @version        1.0.0
 * @package        implecode-business/framework/frontend
 * @author        Norbert Dreszer
 */
define( 'IC_FRAMEWORK_FRONTEND_FOLDER', get_template_directory_uri() . '/framework/frontend' );
define( 'IC_FRAMEWORK_FRONTEND_FOLDER_PATH', dirname( __FILE__ ) );

require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/header.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/quick-access.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/content.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/footer.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/general.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/functions.php');
require_once(IC_THEME_DIR_PATH . '/framework/frontend/css/css-functions.php');

if ( function_exists( 'implecode_addons' ) ) {
	require_once(IC_THEME_DIR_PATH . '/framework/frontend/functions/product-catalog.php');
}

function implecode_business_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'implecode-frontend' );
	wp_enqueue_script( 'implecode-scripts' );
	wp_enqueue_style( 'implecode-ui-css' );
	wp_enqueue_style( 'ic_google_open_sans' );
	wp_enqueue_script( 'html5shiv' );
	if ( function_exists( 'wp_script_add_data' ) ) {
		wp_script_add_data( 'html5shiv', 'conditional', 'IE' );
	}
	wp_enqueue_script( 'jquery-mobile' );
}

add_action( 'wp_enqueue_scripts', 'implecode_business_styles' );

function register_fontent_business_styles() {
	wp_register_style( 'implecode-frontend', IC_FRAMEWORK_FRONTEND_FOLDER . '/css/implecode-frontend.css?' . filemtime( IC_FRAMEWORK_FRONTEND_FOLDER_PATH . '/css/implecode-frontend.css' ) );
	wp_register_script( 'html5shiv', IC_FRAMEWORK_FRONTEND_FOLDER . '/js/html5shiv.min.js', array( 'jquery' ) );
	wp_register_script( 'jquery-mobile', IC_FRAMEWORK_FOLDER . '/ext/jquery.mobile.custom/jquery.mobile.custom.min.js', array( 'jquery' ) );
	wp_register_script( 'implecode-scripts', IC_FRAMEWORK_FRONTEND_FOLDER . '/js/implecode-scripts.js?' . filemtime( IC_FRAMEWORK_FRONTEND_FOLDER_PATH . '/js/implecode-scripts.js' ), array( 'jquery-effects-slide' ) );
	wp_register_style( 'ic_google_open_sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin,latin-ext' );
}

add_action( 'init', 'register_fontent_business_styles' );
