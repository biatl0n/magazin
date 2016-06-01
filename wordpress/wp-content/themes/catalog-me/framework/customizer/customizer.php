<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme customizer
 *
 * @version		1.0.0
 * @package		catalog-me/framework/customizer
 * @author 		Norbert Dreszer
 */
add_action( 'customize_register', 'catalog_me_customizer' );

/**
 * Registers customizer settings
 *
 * @param object $wp_customize
 */
function catalog_me_customizer( $wp_customize ) {
	require_once(IC_THEME_DIR_PATH . '/framework/customizer/controls.php');
	//echo '<style>#customize-control-ic_favicon .current {max-width: 50px; margin: 0 auto 8px auto;}</style>';
	/** COLORS * */
	$wp_customize->add_setting( 'header_color', array(
		'default'			 => '#757575',
		'sanitize_callback'	 => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
		'label'		 => __( 'Header Color', 'catalog-me' ),
		'section'	 => 'colors',
		'settings'	 => 'header_color',
	) ) );
	$wp_customize->add_setting( 'footer_color', array(
		'default'			 => '#141414',
		'sanitize_callback'	 => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
		'label'		 => __( 'Footer Color', 'catalog-me' ),
		'section'	 => 'colors',
		'settings'	 => 'footer_color',
	) ) );
	/** HEADER * */
	$wp_customize->add_section( 'implecode_header', array(
		'title'		 => __( 'Header', 'catalog-me' ),
		'priority'	 => 30,
	) );
	$wp_customize->add_setting( 'ic_encourage_message', array(
		'default'			 => __( 'Let\'s Talk About Your Needs', 'catalog-me' ),
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'ic_phone_number', array(
		'default'			 => '555-555-555',
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'ic_email_address', array(
		'default'			 => 'example@example.com',
		'sanitize_callback'	 => 'sanitize_email',
	) );
	$wp_customize->add_setting( 'ic_logo_type', array(
		'default'			 => 'website_title',
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'ic_website_logo', array(
		'default'			 => IC_FRAMEWORK_FOLDER . '/img/catalog-me-logo.png',
		'sanitize_callback'	 => 'esc_url',
	) );
	$wp_customize->add_setting( 'ic_favicon', array(
		'default'			 => '',
		'sanitize_callback'	 => 'esc_url',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_encourage_message', array(
		'label'		 => __( 'Encourage Message', 'catalog-me' ),
		'section'	 => 'implecode_header',
		'settings'	 => 'ic_encourage_message',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_phone_number', array(
		'label'		 => __( 'Phone Number', 'catalog-me' ),
		'section'	 => 'implecode_header',
		'settings'	 => 'ic_phone_number',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_email_address', array(
		'label'		 => __( 'Email Address', 'catalog-me' ),
		'section'	 => 'implecode_header',
		'settings'	 => 'ic_email_address',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_logo_type', array(
		'label'		 => __( 'Logo Type', 'catalog-me' ),
		'section'	 => 'implecode_header',
		'settings'	 => 'ic_logo_type',
		'type'		 => 'radio',
		'choices'	 => array( 'image' => __( 'Image', 'catalog-me' ), 'website_title' => __( 'Website Title', 'catalog-me' ), 'both' => __( 'Both', 'catalog-me' ) )
	) ) );
	$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ic_website_logo', array(
		'label'		 => __( 'Logo', 'catalog-me' ),
		'section'	 => 'implecode_header',
		'settings'	 => 'ic_website_logo',
	) ) );
	if ( !function_exists( 'has_site_icon' ) ) {
		$wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'ic_favicon', array(
			'label'		 => __( 'Favicon', 'catalog-me' ),
			'section'	 => 'implecode_header',
			'settings'	 => 'ic_favicon',
		) ) );
	}
	/** QUICK ACCESS * */
	$qc_defaults = ic_default_quick_access_settings();
	$wp_customize->add_section( 'implecode_quick_access', array(
		'title'		 => __( 'Quick Access', 'catalog-me' ),
		'priority'	 => 30,
	) );
	$wp_customize->add_setting( 'ic_qc_enable', array(
		'default'			 => $qc_defaults[ 'enable' ],
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_setting( 'ic_qc_per_line', array(
		'default'			 => $qc_defaults[ 'per_line' ],
		'sanitize_callback'	 => 'implecode_intval',
	) );
	$wp_customize->add_setting( 'ic_qc_only_home', array(
		'default'			 => $qc_defaults[ 'only_home' ],
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_qc_enable', array(
		'label'		 => __( 'Enable Quick Access', 'catalog-me' ),
		'section'	 => 'implecode_quick_access',
		'settings'	 => 'ic_qc_enable',
		'type'		 => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_qc_only_home', array(
		'label'		 => __( 'Only on Home', 'catalog-me' ),
		'section'	 => 'implecode_quick_access',
		'settings'	 => 'ic_qc_only_home',
		'type'		 => 'checkbox',
	) ) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_qc_per_line', array(
		'label'		 => __( 'Per Line', 'catalog-me' ),
		'section'	 => 'implecode_quick_access',
		'settings'	 => 'ic_qc_per_line',
		'type'		 => 'number',
	) ) );
	if ( function_exists( 'impleCode_EPC' ) ) {
		$cs_defaults = ic_default_content_settings();
		$wp_customize->add_section( 'implecode_product_catalog', array(
			'title'		 => __( 'Product Catalog', 'catalog-me' ),
			'priority'	 => 30,
		) );
		$wp_customize->add_setting( 'ic_product_sidebar', array(
			'default'			 => $cs_defaults[ 'product_sidebar' ],
			'sanitize_callback'	 => 'sanitize_text_field',
		) );
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'ic_product_sidebar', array(
			'label'		 => __( 'Separate Product Sidebar', 'catalog-me' ),
			'section'	 => 'implecode_product_catalog',
			'settings'	 => 'ic_product_sidebar',
			'type'		 => 'checkbox',
		) ) );
	}
	/** MORE * */
	$wp_customize->add_section( 'implecode_more', array(
		'title'		 => __( 'More', 'catalog-me' ),
		'priority'	 => 1000,
	) );
	$wp_customize->add_setting( 'implecode_more', array(
		'default'			 => '',
		'sanitize_callback'	 => 'sanitize_text_field',
	) );
	$wp_customize->add_control( new More_impleCode_Control( $wp_customize, 'implecode_more', array(
		'label'		 => __( 'Looking for more options?', 'catalog-me' ),
		'section'	 => 'implecode_more',
		'settings'	 => 'implecode_more',
	) ) );
}

add_action( 'ic_before-header', 'catalog_me_customize_css' );

function catalog_me_customize_css() {
	$header_color	 = sanitize_hex_color( get_theme_mod( 'header_color', '#757575' ) );
	$footer_color	 = sanitize_hex_color( get_theme_mod( 'footer_color', '#141414' ) );
	$quick_settings	 = ic_quick_access_settings();
	?>
	<style type="text/css">
		#masthead, ul.sub-menu { background:<?php echo $header_color; ?>; }
		<?php if ( $header_color != '#909090' ) { ?>
			#site-navigation .menu > li.current_page_item > a, #site-navigation .menu > li.current-menu-item > a, #site-navigation .menu > li.current-menu-parent > a {background: transparent;   border-bottom: 2px solid rgba(0, 0, 0, 0.5);}<?php }
		?>
		.site-footer {background:<?php echo $footer_color; ?>;}
		<?php $quick_width = number_format( 100 / $quick_settings[ 'per_line' ], 2 ); ?>
		div.quick-element {
			max-width: <?php echo $quick_width ?>%;
		}
	</style>
	<?php
}

if ( !function_exists( 'sanitize_hex_color' ) ) {

	/**
	 * A copy of WP core function for frontend usage
	 *
	 * @param string $color
	 * @return string
	 */
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return null;
	}

}

/**
 * Intval without second parameter
 *
 * @param int $number
 * @return int
 */
function implecode_intval( $number ) {
	return intval( $number );
}
