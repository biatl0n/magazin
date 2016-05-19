<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Omega
 */

get_header(); ?>

	<main  class="<?php echo apply_atomic( 'main_class', 'content' );?>" role="main" itemprop="mainContentOfPage">

		<?php 
		do_atomic( 'before_content' ); // omega_before_content 

		woocommerce_content(); 
		
		do_atomic( 'after_content' ); // omega_after_content 
		?>

	</main><!-- .content -->

<?php get_footer(); ?>
