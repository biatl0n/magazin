<?php
/**
 * @package implecode
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'catalog-me' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'catalog-me' ) );

		if ( !implecode_categorized_blog() ) {
			// This blog only has 1 category so we just need to worry about tags in the meta text
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was tagged %2$s.', 'catalog-me' );
			} else {
				$meta_text = '';
			}
		} else {
			// But this blog has loads of categories so we should probably display them here
			if ( '' != $tag_list ) {
				$meta_text = __( 'This entry was posted in %1$s and tagged %2$s.', 'catalog-me' );
			} else {
				$meta_text = __( 'This entry was posted in %1$s.', 'catalog-me' );
			}
		} // end check for categories on this blog

		printf(
		$meta_text, $category_list, $tag_list, get_permalink()
		);
		?>

		<?php
		edit_post_link( __( 'Edit', 'catalog-me' ), '<span class="edit-link">', '</span>' );
		do_action( 'ic_before_bio_box' );
		$userID = $post->post_author;
		echo ic_bio_box_func( $userID );
		?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
