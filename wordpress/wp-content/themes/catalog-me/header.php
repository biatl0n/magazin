<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package implecode
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<?php $header_settings = ic_header_settings(); ?>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<div id="page" class="hfeed site">
			<?php do_action( 'ic_before-header', $header_settings, 'top' ); ?>
			<header id="masthead" class="site-header" role="banner">
				<button class="responsive-menu-toggle"><span class="screen-reader-text"><?php _e( 'Toggle
 Menu', 'catalog-me' ) ?></span></button>
				<div class="head-container">
					<?php
					do_action( 'ic_head-container', $header_settings, 'main_header' );
					if ( has_nav_menu( 'primary' ) ) {
						?>
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<?php
							wp_nav_menu( array( 'theme_location' => 'primary', 'walker' => new ic_nav_menu_arrow ) );
							?>
						</nav><!-- #site-navigation -->
					<?php } ?>
				</div>
			</header><!-- #masthead -->
			<?php do_action( 'ic_after-header', $header_settings, 'bottom' ); ?>
			<div id="content" class="site-content">

