<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package implecode
 */
get_header();
?>
<?php
if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
}
?>
<div id="primary" class="content-area">
	<div id="container_sidebar_wrap">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>


				<?php
			endwhile; // end of the loop.

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;
			?>
		</main><!-- #main -->
		<div id="main_sidebar" role="complementary"><?php
			the_post_thumbnail( 'large' );
			do_action( 'ic_page_sidebar_start' );
			dynamic_sidebar( 'right-sidebar' );
			?>
		</div><?php
		if ( is_front_page() ) {
			ob_start();
			dynamic_sidebar( 'home-sidebar' );
			$sidebar = ob_get_clean();  // get the contents of the buffer and turn it off.
			if ( $sidebar ) {
				echo '<div id="home_sidebar" role="complementary">' . $sidebar . '</div>';
			}
		}
		?>
	</div>
</div><!-- #primary -->

<?php
get_footer();
