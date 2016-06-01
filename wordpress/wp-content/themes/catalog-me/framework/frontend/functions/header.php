<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme branding
 *
 * Here theme branding is defined and managed.
 *
 * @version		1.0.0
 * @package		implecode-business/framework/frontend
 * @author 		Norbert Dreszer
 */
function ic_header_settings() {
	$options						 = ic_default_header_settings();
	$options[ 'website_logo' ]		 = get_theme_mod( 'ic_website_logo', $options[ 'website_logo' ] );
	$options[ 'logo_type' ]			 = get_theme_mod( 'ic_logo_type', $options[ 'logo_type' ] );
	$options[ 'encourage_message' ]	 = get_theme_mod( 'ic_encourage_message', $options[ 'encourage_message' ] );
	$options[ 'address' ]			 = ic_theme_general_settings();
	return apply_filters( 'ic_header_settings', $options );
}

function ic_default_header_settings() {
	$default = array(
		'website_logo'		 => IC_FRAMEWORK_FOLDER . '/img/catalog-me-logo.png',
		'logo_type'			 => 'website_title',
		'encourage_message'	 => __( 'Let\'s Talk About Your Needs', 'catalog-me' ),
	);
	return $default;
}

add_action( 'ic_head-container', 'implecode_logo', 10, 2 );
add_action( 'ic_additional_header', 'implecode_logo', 10, 2 );

function implecode_logo( $options, $pos ) {
	if ( 'additional_header' == $pos ) {
		?>
		<div class="site-branding">
			<a href="<?php echo home_url(); ?>"><?php
				if ( $options[ 'logo_type' ] != 'website_title' ) {
					?>
					<img width="200" src="<?php echo $options[ 'website_logo' ]; ?>" alt="<?php _e( 'Website Logo', 'catalog-me' ) ?>" />
				<?php } else {
					?><div class="website_name" itemprop="name"><?php echo get_bloginfo( 'name' ) ?></div><div class="website_slogan"><?php echo get_bloginfo( 'description' ) ?></div><?php }
				?>
			</a>
		</div> <?php if ( $options[ 'logo_type' ] == 'both' ) { ?>
			<div class="name_slogan"><div class="website_name" itemprop="name"><?php echo get_bloginfo( 'name' ) ?></div><div class="website_slogan"><?php echo get_bloginfo( 'description' ) ?></div></div><?php
		}
	}
}

add_action( 'ic_before-header', 'ic_additional_header', 10, 2 );
add_action( 'ic_after-header', 'ic_additional_header', 10, 2 );

function ic_additional_header( $options, $pos ) {
	$options[ 'additional_header_menu' ] = isset( $options[ 'additional_header_menu' ] ) ? $options[ 'additional_header_menu' ] : '';
	if ( 'top' == $pos ) {
		if ( strpos( $options[ 'address' ][ 'email_address' ], '@' ) !== false ) {
			$em				 = explode( '@', $options[ 'address' ][ 'email_address' ] );
			$email_script	 = '<!--noptimize--><script type="text/javascript">gen_mail_to_link("' . $em[ 0 ] . '", "' . $em[ 1 ] . '",0);</script><!--/noptimize-->';
		}
		?>
		<div id="top_header">
			<div class="additional_header_container" itemscope="" itemtype="http://schema.org/Organization">
				<!--noptimize--><script type="text/javascript"> function gen_mail_to_link( lhs, rhs, link ) {
						link = typeof link !== 'undefined' ? link : 1;
						if ( link == 1 ) {
							document.write( '<a href="mailto:' + lhs + "@" + rhs + '">' );
						}
						document.write( lhs + "@" + rhs );
						if ( link == 1 ) {
							document.write( '<\/a>' )
						}
		                    }</script><!--/noptimize-->
				<?php
				do_action( 'ic_additional_header', $options, 'additional_header' );
				?>
				<div class="contact"><?php
					if ( !empty( $options[ 'encourage_message' ] ) ) {
						?>
						<div class="encourage_message"><?php echo $options[ 'encourage_message' ] ?></div><?php
					}
					if ( !empty( $options[ 'address' ][ 'phone_number' ] ) ) {
						?>
						<div class="phone_number"><?php echo $options[ 'address' ][ 'phone_number' ] ?></div><?php
					}
					if ( !empty( $options[ 'address' ][ 'email_address' ] ) && isset( $email_script ) ) {
						?>
						<div class="email_address"><?php echo $email_script; ?></div><?php
					}
					?>
				</div>
				<?php /* <div style="clear: both;"></div> */ ?>
			</div>
		</div>
		<?php
	}
}
