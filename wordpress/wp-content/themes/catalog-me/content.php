<?php
/**
 * @package implecode
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php implecode_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() || is_category() || is_tag() || is_archive() || is_home() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php
			the_content( sprintf( __( 'Continue reading <span class="meta-nav">&rarr;</span>%s', 'catalog-me' ), '<span class="screen-reader-text">  ' . get_the_title() . '</span>'
			) );
			?>
			<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'catalog-me' ),
				'after'	 => '</div>',
			) );
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-meta">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
			$categories_list = get_the_category_list( ', ' );
			if ( $categories_list && implecode_categorized_blog() ) :
				?>
				<span class="cat-links">
					<?php printf( __( 'Posted in %1$s', 'catalog-me' ), $categories_list ); ?>
				</span>
			<?php endif; // End if categories  ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'catalog-me' ) );
			if ( $tags_list ) :
				?>
				<span class="tags-links">
					<?php printf( __( 'Tagged %1$s', 'catalog-me' ), $tags_list ); ?>
				</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type()  ?>

		<?php if ( !post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<div class="readmore-wrapper">
				<span class="read-more"><a href="<?php echo get_permalink() ?>"><?php
						echo
						sprintf( __( 'Continue reading%s', 'catalog-me' ), '<span class="screen-reader-text">  ' . get_the_title() . '</span>'
						)
						?></a></span>
				<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'catalog-me' ), __( '1 Comment', 'catalog-me' ), __( '% Comments', 'catalog-me' ) ); ?></span>
			</div>
		<?php elseif ( !post_password_required() ) : ?>
			<div class="readmore-wrapper">
				<span class="read-more"><a href="<?php echo get_permalink() ?>"><?php
						echo
						sprintf( __( 'Continue reading%s', 'catalog-me' ), '<span class="screen-reader-text">  ' . get_the_title() . '</span>'
						)
						?></a>
				</span>
			</div>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'catalog-me' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
