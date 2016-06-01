<?php
/**
 * The Template for displaying all single posts.
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

				<?php get_template_part( 'content', 'single' ); ?>

				<?php implecode_post_nav(); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
				?>

			<?php endwhile; // end of the loop.  ?>

		</main><!-- #main -->
		<div id="main_sidebar" role="complementary">
			<?php dynamic_sidebar( 'right-sidebar' ); ?>
		</div>
	</div>
</div><!-- #primary -->


<?php
get_footer();
