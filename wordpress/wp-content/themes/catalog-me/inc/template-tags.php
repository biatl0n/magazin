<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package implecode
 */
if ( !function_exists( 'implecode_post_nav' ) ) :

	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @return void
	 */
	function implecode_post_nav() {
		// Don't print empty markup if there's nowhere to navigate.
		$previous	 = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next		 = get_adjacent_post( false, '', false );

		if ( !$next && !$previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'catalog-me' ); ?></h1>
			<div class="nav-links">
				<?php
				previous_post_link( '<div class="nav-previous classic-button">%link</div>', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'catalog-me' ) );
				next_post_link( '<div class="nav-next classic-button">%link</div>', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'catalog-me' ) );
				?>
			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}

endif;

if ( !function_exists( 'implecode_posted_on' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function implecode_posted_on() {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string .= '<time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string, esc_attr( get_the_date( 'c' ) ), esc_html( get_the_date() ), esc_attr( get_the_modified_date( 'c' ) ), esc_html( get_the_modified_date() )
		);
		if ( get_post_type() == 'post' ) {
			printf( __( '<span class="posted-on">%1$s</span><span class="byline"> by %2$s</span>', 'catalog-me' ), sprintf( '%2$s', esc_url( get_permalink() ), $time_string
			), sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), esc_html( get_the_author() )
			)
			);
		} else {
			printf( __( '<span class="posted-on">%s</span>', 'catalog-me' ), $time_string );
		}
	}

endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function implecode_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so implecode_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so implecode_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in implecode_categorized_blog.
 */
function implecode_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}

add_action( 'edit_category', 'implecode_category_transient_flusher' );
add_action( 'save_post', 'implecode_category_transient_flusher' );
