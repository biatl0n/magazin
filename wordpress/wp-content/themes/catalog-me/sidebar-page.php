<?php
/**
 * Template Name: No Sidebar Page
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
	<div id="no_sidebar_wrap">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
		<?php
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
