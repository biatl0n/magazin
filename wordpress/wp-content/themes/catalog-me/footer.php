<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package implecode
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer" role="contentinfo">
	<div class="footer-content">
		<div class="footer-sidebar-left footer-area"><?php dynamic_sidebar( 'sidebar-footer-left' ); ?>
		</div>
		<div class="footer-sidebar-middle footer-area"><?php dynamic_sidebar( 'sidebar-footer-middle' ); ?>
		</div>
		<div class="footer-sidebar-right footer-area"><?php dynamic_sidebar( 'sidebar-footer-right' ); ?>
		</div>
	</div>
	<div class="site-info">
		<?php
		do_action( 'implecode_credits' );
		if ( has_nav_menu( 'bottom_footer_menu' ) ) {
			?>
			<div class="bottom-footer-menu"><?php wp_nav_menu( array( 'theme_location' => 'bottom_footer_menu', 'fallback_cb' => false, ) ); ?></div>
		<?php } ?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>