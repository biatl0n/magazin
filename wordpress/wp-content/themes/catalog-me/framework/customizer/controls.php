<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * Defines customizer controls
 *
 * @created Apr 9, 2015
 * @package catalog-me/framework/customizer
 */

/**
 * Control to display info
 */
class More_impleCode_Control extends WP_Customize_Control {

	public function render_content() {
		?>
		<label style="overflow: hidden; zoom: 1;">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<p>
				<?php
				printf( __( 'There\'s a range of Catalog Me! add-ons available to put additional power in your hands. Check out the %sCatalog Me!%s page in your dashboard for more information.', 'catalog-me' ), '<a href="' . esc_url( admin_url() . 'themes.php?page=implecode-settings' ) . '">', '</a>' );
				?>
			</p>

			<span class="customize-control-title"><?php _e( 'Enjoying Catalog Me! theme?', 'catalog-me' ); ?></span>
			<p>
				<?php
				printf( __( 'Why not leave us a review on %sWordPress.org%s?  We\'d really appreciate it!', 'catalog-me' ), '<a href="https://wordpress.org/themes/catalog-me">', '</a>' );
				?>
			</p>
		</label>
		<?php
	}

}
