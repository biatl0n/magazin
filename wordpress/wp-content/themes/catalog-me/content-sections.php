<?php
/**
 * The template used for displaying sections in sections.php
 *
 * @package implecode
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


	<div class="entry-content">
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'catalog-me' ),
			'after'	 => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<?php edit_post_link( __( 'Edit', 'catalog-me' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->
