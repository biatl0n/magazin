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
 * @package		implecode-business/framework/admin
 * @author 		Norbert Dreszer
 */
define( 'IC_ADMIN_PATH_SERVER', dirname( __FILE__ ) );
define( 'IC_FRAMEWORK_ADMIN_FOLDER', get_template_directory_uri() . '/framework/admin' );
define( 'IC_FRAMEWORK_ADMIN_MAIN_FILE_SERVER', __FILE__ );
add_action( 'admin_init', 'ic_register_admin_scripts' );

function ic_register_admin_scripts() {
	wp_register_script( 'implecode-admin-scripts', IC_FRAMEWORK_ADMIN_FOLDER . '/js/admin.js', array( 'jquery', 'wp-color-picker' ) );
	wp_register_style( 'implecode-framework', IC_FRAMEWORK_ADMIN_FOLDER . '/css/implecode-admin.css' );
}

add_action( 'admin_enqueue_scripts', 'implecode_business_admin_styles', 11 );

function implecode_business_admin_styles( $hook ) {
	if ( $hook == 'appearance_page_implecode-settings' || $hook == 'widgets.php' ) {
		wp_enqueue_style( 'implecode-framework' );
		wp_enqueue_script( 'implecode-admin-scripts' );
	}
}

require_once(IC_THEME_DIR_PATH . '/framework/admin/includes/index.php');
require_once(IC_THEME_DIR_PATH . '/framework/admin/functions/index.php');

add_action( 'admin_menu', 'register_implecode_menu' );

function register_implecode_menu() {
	add_theme_page( 'Theme Settings', __( 'Catalog Me!', 'catalog-me' ), 'edit_theme_options', 'implecode-settings', 'implecode_settings_page' );
}

function implecode_settings_page() {
	$tab		 = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
	$submenu	 = isset( $_GET[ 'submenu' ] ) ? $_GET[ 'submenu' ] : $tab;
	?>
	<div id="implecode_settings" class="wrap">
		<?php
		$catalogme	 = wp_get_theme( 'catalog-me' );
		?>
		<div style="margin-bottom: 1.618em; overflow: hidden; width: 90%;padding-top: 20px;">
			<div style="overflow: hidden; margin-bottom: 20px;">
				<div style="width: 52%; float: left;padding-left:2%;">
					<h1 style="margin-right: 0; font-size: 2.8em"><?php echo '<strong>Catalog Me!</strong> <sup style="font-weight: bold; font-size: 50%; padding: 5px 10px; color: #666; background: #fff;">' . esc_attr( $catalogme[ 'Version' ] ) . '</sup>'; ?></h1>

					<p style="font-size: 1.4em;"><?php _e( 'Awesome! You\'ve decided to use Catalog Me! to enhance your eCommerce Product Catalog.', 'catalog-me' ); ?></p>
					<p style="font-size: 1.1em;"><?php _e( 'Catalog Me! is designed to provide smooth eCommerce Product Catalog integration, flexible layout for all screen sizes and extensible codebase.', 'catalog-me' ) ?></p>
					<p style="font-size: 1.1em;"><?php _e( 'We hope it will serve well your new project!', 'catalog-me' ) ?></p>
				</div>
				<div style="width: 45%; float: right;">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" alt="Catalog Me!" class="image-50" width="440" />
				</div>
			</div>
			<div style="clear: left; padding-left: 2%;width: 47%; float: left;">
				<h2><?php _e( 'Using Catalog Me!', 'catalog-me' ) ?></h2>
				<?php if ( !function_exists( 'implecode_addons' ) ) { ?>
					<h4><?php _e( 'Install eCommerce Product Catalog', 'catalog-me' ) ?></h4>
					<p style="font-size: 1.1em;"><?php _e( 'Catalog Me! is designed as all purpose WordPress theme, however if you need to show your products to the public its smooth integration with eCommerce Product Catalog will make your life easier.', 'catalog-me' ) ?></p>
					<a class="button-primary" href="<?php echo admin_url( 'plugin-install.php?tab=search&type=term&s=ecommerce+product+catalog+by+implecode' ) ?>"><?php _e( 'Install eCommerce Product Catalog', 'catalog-me' ) ?></a>
				<?php } ?>
				<h4><?php _e( 'Assign theme menus', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php _e( 'Catalog Me! theme can have two menus. One is the main menu for your most important pages. Another menu shows in the footer at the very bottom of your website.', 'catalog-me' ) ?></p>
				<p style="font-size: 1.1em;"><?php _e( 'Create your menus and assign them to the correct positions now.', 'catalog-me' ) ?></p>
				<a class="button" href="<?php echo admin_url( 'nav-menus.php' ) ?>"><?php _e( 'Assign Menus', 'catalog-me' ) ?></a>
				<h4><?php _e( 'Set Theme Colors', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php _e( 'Use WordPress customizer to set background, header and footer colors to match your brand.', 'catalog-me' ) ?></p>
				<a class="button" href="<?php echo admin_url( 'customize.php' ) ?>"><?php _e( 'Open Customizer', 'catalog-me' ) ?></a>
				<h4><?php _e( 'Set logo and contact', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php _e( 'Use the customizer to upload your own logo and set your contact details. It is also highly recommended to set your own favicon.', 'catalog-me' ) ?></p>
				<a class="button" href="<?php echo admin_url( 'customize.php' ) ?>"><?php _e( 'Open Customizer', 'catalog-me' ) ?></a>
				<h4><?php _e( 'Assign widgets', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php _e( 'Catalog Me! comes with up to 6 widget areas. 3 in the footer, 1 is a quick access under the main menu, 1 at the bottom of fron-page and 1 sidebar.', 'catalog-me' ) ?></p>
				<a class="button" href="<?php echo admin_url( 'widgets.php' ) ?>"><?php _e( 'Assign widgets', 'catalog-me' ) ?></a>
			</div>
			<div style="clear: right; padding-left: 2%;width: 47%; float: right; padding-top: 42px;">
				<h4><?php _e( 'Catalog Me! translations', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php _e( 'It\'s less than 1 minute to add some translations to Catalog Me! collaborative translation project.', 'catalog-me' ) ?></p>
				<a class="button-primary" href="http://translate.implecode.com/projects/catalog-me"><?php _e( 'Add Your Translations', 'catalog-me' ) ?></a>
				<h4><?php _e( 'Are you enjoying Catalog Me! theme?', 'catalog-me' ) ?></h4>
				<p style="font-size: 1.1em;"><?php echo sprintf( __( 'Why not leave a review on %sWordPress.org%s? We\'d really appreciate it! :-)', 'catalog-me' ), '<a href="https://wordpress.org/themes/catalog-me">', '</a>' ) ?></p>
				<a class="button" href="https://wordpress.org/themes/catalog-me"><?php _e( 'Rate Catalog Me!', 'catalog-me' ) ?></a>
			</div>
		</div>
		<div class="plugin-logo">
			<a href="http://implecode.com"><img class="en" src="<?php echo IC_FRAMEWORK_FOLDER; ?>/img/implecode.png" width="282px" alt="WordPress Consulting & Plugin Development"></a>
		</div>
	</div>
	<?php
}
