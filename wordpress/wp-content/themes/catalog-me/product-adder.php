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
$content_settings	 = ic_content_settings();
$page_id			 = get_product_listing_id();
$page_template		 = get_page_template_slug( $page_id );
$id					 = 'container_sidebar_wrap';
if ( $page_template == 'sidebar-page.php' ) {
	$id = 'no_sidebar_wrap';
} else if ( $page_template == 'sections.php' ) {
	$id = 'sections';
}
do_action( 'advanced_mode_layout_start' );
?>

<div id="primary" class="content-area">
	<div id="<?php echo $id ?>">
		<?php do_action( 'advanced_mode_layout_before_content' ); ?>
		<main id="main" class="site-main" role="main">

			<?php content_product_adder(); ?>

		</main><!-- #main -->
		<?php
		if ( $content_settings[ 'product_sidebar' ] == 1 ) {
			echo '<div class="product-sidebar">';
			do_action( 'ic_product_sidebar_start' );
			dynamic_sidebar( 'product-sidebar' );
			echo '</div>';
		} else {

		}
		do_action( 'advanced_mode_layout_after_content' );
		?>
	</div>
</div><!-- #primary -->

<?php
do_action( 'advanced_mode_layout_end' );
get_footer();
