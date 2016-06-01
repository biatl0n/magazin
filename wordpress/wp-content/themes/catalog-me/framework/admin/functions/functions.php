<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Manages theme general settings
 *
 * Here theme general settings are defined and managed.
 *
 * @version        1.0.0
 * @package        implecode-business/framework/admin/functions
 * @author        Norbert Dreszer
 */
if ( !function_exists( 'echo_ic_setting' ) ) {

	function echo_ic_setting( $return, $echo = 1 ) {
		if ( $echo == 1 ) {
			echo $return;
		} else {
			return $return;
		}
	}

}

if ( !function_exists( 'select_page' ) ) {

	function select_page( $option_name, $first_option, $selected_value, $buttons = false, $custom_view_url = false,
					   $echo = 1, $custom = false ) {
		$args		 = array(
			'sort_order'	 => 'ASC',
			'sort_column'	 => 'post_title',
			'hierarchical'	 => 1,
			'exclude'		 => '',
			'include'		 => '',
			'meta_key'		 => '',
			'meta_value'	 => '',
			'authors'		 => '',
			'child_of'		 => 0,
			'parent'		 => -1,
			'exclude_tree'	 => '',
			'number'		 => '',
			'offset'		 => 0,
			'post_type'		 => 'page',
			'post_status'	 => 'publish'
		);
		$pages		 = get_pages( $args );
		$select_box	 = '<div class="select-page-wrapper"><select id="' . $option_name . '" name="' . $option_name . '"><option value="noid">' . $first_option . '</option>';
		foreach ( $pages as $page ) {
			$select_box .= '<option name="' . $option_name . '[' . $page->ID . ']" value="' . $page->ID . '" ' . selected( $page->ID, $selected_value, 0 ) . '>' . $page->post_title . '</option>';
		}
		if ( $custom ) {
			$select_box .= '<option value="custom"' . selected( 'custom', $selected_value, 0 ) . '>' . __( 'Custom URL', 'catalog-me' ) . '</option>';
		}
		$select_box .= '</select>';
		if ( $buttons && $selected_value != 'noid' && !empty( $selected_value ) ) {
			$edit_link	 = get_edit_post_link( $selected_value );
			$front_link	 = $custom_view_url ? $custom_view_url : get_permalink( $selected_value );
			if ( !empty( $edit_link ) ) {
				$select_box .= ' <a class="button button-small" style="vertical-align: middle;" href="' . $edit_link . '">' . __( 'Edit', 'catalog-me' ) . '</a>';
				$select_box .= ' <a class="button button-small" style="vertical-align: middle;" href="' . $front_link . '">' . __( 'View Page', 'catalog-me' ) . '</a>';
			}
		}
		$select_box .= '</div>';
		return echo_ic_setting( $select_box, $echo );
	}

}
if ( !function_exists( 'permalink_options_update' ) ) {

	function permalink_options_update() {
		update_option( 'al_permalink_options_update', 1 );
	}

}
add_action( 'admin_notices', 'catalogme_welcome_admin_notice' );

function catalogme_welcome_admin_notice() {
	global $pagenow;
	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET[ 'activated' ] ) ) {
		?>
		<div class="updated notice is-dismissible">
			<p><?php echo sprintf( esc_html__( 'Thanks for choosing Catalog Me! Make sure to see the %swelcome screen%s to learn more on the possibilities and configuration.', 'catalog-me' ), '<a href="' . esc_url( admin_url( 'themes.php?page=implecode-settings' ) ) . '">', '</a>' ); ?></p>
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=implecode-settings' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with Catalog Me!', 'catalog-me' ); ?></a></p>
		</div>
		<?php
	}
}
