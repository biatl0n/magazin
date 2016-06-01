<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme branding
 *
 * Here theme branding is defined and managed.
 *
 * @version        1.0.0
 * @package        implecode-business/framework/frontend
 * @author        Norbert Dreszer
 */
function ic_quick_access_settings() {
	$options				 = ic_default_quick_access_settings();
	$options[ 'enable' ]	 = get_theme_mod( 'ic_qc_enable', $options[ 'enable' ] );
	$options[ 'per_line' ]	 = get_theme_mod( 'ic_qc_per_line', $options[ 'per_line' ] );
	$options[ 'only_home' ]	 = get_theme_mod( 'ic_qc_only_home', $options[ 'only_home' ] );
	return $options;
}

function ic_default_quick_access_settings() {
	$default = array(
		'enable'	 => 1,
		'per_line'	 => 3,
		'only_home'	 => 1,
	);
	return $default;
}

function is_ic_quick_access_enabled() {
	$settings = ic_quick_access_settings();
	if ( $settings[ 'enable' ] == 1 && ($settings[ 'only_home' ] == 0 || ($settings[ 'only_home' ] == 1 && is_front_page())) ) {
		return true;
	} else {
		return false;
	}
}

function ic_show_quick_access( $options, $pos ) {
	if ( is_ic_quick_access_enabled() && is_active_sidebar( 'quick_access' ) ) {
		echo '<div class="quick_wrapper">';
		echo '<div class="quick_inside_wrapper">';
		dynamic_sidebar( 'quick_access' );
		echo '</div>';
		echo '</div>';
	}
}

add_action( 'ic_after-header', 'ic_show_quick_access', 25, 2 );

function ic_register_quick_access_sidebar() {
	$args = array(
		'name'			 => __( 'Quick Access', 'catalog-me' ),
		'id'			 => 'quick_access',
		'description'	 => '',
		'class'			 => '',
		'before_widget'	 => '<div id="%1$s" class="widget %2$s">',
		'after_widget'	 => '</div>',
		'before_title'	 => '<h2 class="widgettitle">',
		'after_title'	 => '</h2>',
	);
	register_sidebar( $args );
}

add_action( 'widgets_init', 'ic_register_quick_access_sidebar' );

class ic_quick_access_widget extends WP_Widget {

	function ic_quick_access_widget() {
		// Instantiate the parent object
		$widget_ops = array( 'classname' => 'quick_access_widget', 'description' => __( 'Add a widget to quick access bar.', 'catalog-me' ) );
		parent::__construct( 'quick_access_widget', __( 'Quick Access Widget', 'catalog-me' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		$element			 = '<div class="quick-element">';
		$instance[ 'page' ]	 = isset( $instance[ 'page' ] ) ? $instance[ 'page' ] : 'noid';
		if ( $instance[ 'page' ] != 'noid' ) {
			if ( $instance[ 'page' ] != 'custom' ) {
				$url = get_permalink( $instance[ 'page' ] );
			} else {
				$url = esc_url( $instance[ 'custom_url' ], array( 'http', 'https' ) );
			}
			if ( !empty( $url ) ) {
				$element .= '<a href="' . $url . '" class="block-url"></a>';
			}
		}
		$element .= '<table class="quick-element"><tr>';
		$element .= '<td><img src="' . $instance[ 'image_url' ] . '" alt="' . $instance[ 'title' ] . '" /></td>';
		$element .= '<td><h3>' . $instance[ 'title' ] . '</h3><p>' . $instance[ 'description' ] . '</p></td>';
		$element .= '</tr></table>';
		$element .= '</div>';
		echo $element;
	}

	function form( $instance ) {
		wp_enqueue_media();
		$instance	 = wp_parse_args( (array) $instance, array( 'title' => '', 'description' => '', 'image_url' => '', 'page' => 'noid', 'custom_url' => '' ) );
		$element	 = '<table class="quick-element"><tr>';
		$element .= '<td>' . ic_quick_access_element_image_upload( $instance[ 'image_url' ], $this->get_field_name( 'image_url' ), $this->get_field_id( 'image_url' ) ) . '</td>';
		$element .= '<td><input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" placeholder="' . __( 'Enter element title', 'catalog-me' ) . '" value="' . esc_attr( $instance[ 'title' ] ) . '" /><br><textarea id="' . $this->get_field_id( 'description' ) . '" name="' . $this->get_field_name( 'description' ) . '" placeholder="' . __( 'Enter element description', 'catalog-me' ) . '">' . esc_attr( $instance[ 'description' ] ) . '</textarea></td>';
		$element .= '</tr></table>';
		$element .= select_page( $this->get_field_name( 'page' ), __( 'Select Target Page', 'catalog-me' ), $instance[ 'page' ], false, false, 0, true );
		$display	 = (empty( $instance[ 'custom_url' ] ) && $instance[ 'page' ] == 'custom') ? 'style="display: none"' : '';
		$element .= '<input type="text" placeholder="' . __( 'Enter URL', 'catalog-me' ) . ' ..." class="custom_url" name="' . $this->get_field_name( 'custom_url' ) . '" value="' . $instance[ 'custom_url' ] . '"' . $display . '>';
		echo $element;
	}

}

function ic_quick_access_widget_register() {
	register_widget( 'ic_quick_access_widget' );
}

add_action( 'widgets_init', 'ic_quick_access_widget_register' );
