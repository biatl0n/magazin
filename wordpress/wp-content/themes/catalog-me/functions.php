<?php
/**
 * implecode functions and definitions
 *
 * @package implecode
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( !isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( !function_exists( 'implecode_setup' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function implecode_setup() {
		define( 'IC_THEME_DIR_PATH', get_template_directory() );
		require_once(IC_THEME_DIR_PATH . '/framework/index.php');
		$options = ic_header_settings();
		load_theme_textdomain( 'catalog-me', IC_THEME_DIR_PATH . '/languages' );
		$menus	 = array(
			'primary'			 => __( 'Primary Menu', 'catalog-me' ),
			'bottom_footer_menu' => __( 'Bottom Footer Menu', 'catalog-me' )
		);
		if ( !empty( $options[ 'additional_header_menu' ] ) && $options[ 'additional_header_menu' ] == 1 ) {
			$menus[ 'additional_menu' ] = __( 'Additional Header Menu', 'catalog-me' );
		}
		register_nav_menus( $menus );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );
		add_theme_support( 'custom-background', apply_filters( 'implecode_custom_background_args', array(
			'default-color'	 => 'ededed',
			'default-image'	 => '',
		) ) );
		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form', ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'ecommerce-product-catalog' );
	}

endif; // implecode_setup
add_action( 'after_setup_theme', 'implecode_setup' );
add_action( 'admin_init', 'catalog_me_add_editor_styles' );

/**
 * Adds editor styling to match the theme
 *
 */
function catalog_me_add_editor_styles() {
	add_editor_style( 'editor-style.css' );
}

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function implecode_widgets_init() {
	register_sidebar( array(
		'name'			 => __( 'Right Sidebar', 'catalog-me' ),
		'id'			 => 'right-sidebar',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
	register_sidebar( array(
		'name'			 => __( 'Footer Sidebar Left', 'catalog-me' ),
		'id'			 => 'sidebar-footer-left',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
	register_sidebar( array(
		'name'			 => __( 'Footer Sidebar Middle', 'catalog-me' ),
		'id'			 => 'sidebar-footer-middle',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
	register_sidebar( array(
		'name'			 => __( 'Footer Sidebar Right', 'catalog-me' ),
		'id'			 => 'sidebar-footer-right',
		'before_widget'	 => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</aside>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
	register_sidebar( array(
		'name'			 => __( 'Home Box', 'catalog-me' ),
		'id'			 => 'home-sidebar',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h2 class="widget-title">',
		'after_title'	 => '</h2>',
	) );
	do_action( 'implecode_widgets_init' );
}

add_action( 'widgets_init', 'implecode_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function implecode_scripts() {
	wp_enqueue_style( 'implecode-style', get_stylesheet_uri() );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'implecode_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

add_action( 'ic_before-header', 'main_content_skip_link' );

function main_content_skip_link() {
	echo '<a class="screen-reader-text" href="#main" tabindex="1">' . __( 'Skip to main content', 'catalog-me' ) . '</a>';
}

function implecode_post_thumbnail() {
	if ( post_password_required() || is_attachment() || !has_post_thumbnail() ) {
		return;
	}

	if ( is_singular( 'post' ) ) {
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->

		<?php
	}
}

function implecode_get_link_url() {
	$has_url = get_url_in_content( get_the_content() );

	return $has_url ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

function ic_bio_box_func( $userID ) {
	$name		 = get_the_author_meta( 'display_name', $userID );
	$bio_info	 = wpautop( get_the_author_meta( 'description', $userID ) );
	$avatar		 = get_avatar( $userID, '74', '', $name );
	if ( $bio_info != '' ) {
		return '<div class="bio_box"><div class="bio_image">' . $avatar . '</div><h4 class="bio_name">Post author: <span class="author">' . $name . '</span></h4><div class="bio_description">' . $bio_info . '</div></div>';
	}
}

if ( !function_exists( 'ic_time_ago' ) ) {

	function ic_time_ago( $type = 'comment' ) {
		$d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

		return human_time_diff( $d( 'U' ), current_time( 'timestamp' ) ) . " " . __( 'ago', 'catalog-me' );
	}

}

function implecode_comments( $comment, $args, $depth ) {

	$GLOBALS[ 'comment' ] = $comment;
	?>

	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div
			class="comment-avatar"><?php echo get_avatar( $comment, '48', '', get_the_author_meta( 'display_name' ) ); ?></div>
		<div class="comment-info"><span class="author"><?php echo get_comment_author_link() ?></span><span
				class="time"> - <?php echo ic_time_ago(); ?></span>
		</div>
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em class="moderation">
				<php _e(
					 'Your comment is awaiting moderation.') ?></em>
			<?php endif; ?>
		<div class="comment-text"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args[ 'max_depth' ] ) ) ) ?>
		</div>
	</li><?php
}

class ic_nav_menu_arrow extends Walker_Nav_Menu {

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul class=\"sub-menu\"><li class=\"menu_arrow\"></li>\n";
	}

}

add_filter( 'get_search_form', 'ic_search_form_class' );

function ic_search_form_class( $form ) {
	$form = str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $form );
	return $form;
}
