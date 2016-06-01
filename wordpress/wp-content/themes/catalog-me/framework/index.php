<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages theme settings
 *
 * Here theme settings are defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework
 * @author 		Norbert Dreszer
 */
define( 'IC_FRAMEWORK_FOLDER', get_template_directory_uri() . '/framework' );
define( 'IC_FRAMEWORK_PATH', dirname( __FILE__ ) );
if ( is_admin() ) {
	require_once(IC_THEME_DIR_PATH . '/framework/admin/index.php');
}

require_once(IC_THEME_DIR_PATH . '/framework/frontend/index.php');
require_once(IC_THEME_DIR_PATH . '/framework/customizer/customizer.php');

add_action( "after_switch_theme", "implecode_framework_activation" );

function implecode_framework_activation() {
	do_action( 'implecode_framework_activation' );
}
