<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Manages theme header settings
 *
 * Here theme header settings are defined and managed.
 *
 * @version		1.0.0
 * @package		catalog-me/framework/admin/includes/settings
 * @author 		Norbert Dreszer
 */
function ic_quick_access_element_image_upload( $image_src = null, $name, $id ) {
	$content = '<div class="element-uploader element-' . $name . '">';
	$content .= '<input hidden="hidden" type="text" name="' . $name . '" id="' . $id . '" value="' . $image_src . '" />';
	if ( $image_src != '' ) {
		$content .= '<img class="media-image" src="' . $image_src . '" />';
	} else {
		$content .= '<a href="#" class="button" name="add_quick_image" number="' . $name . '" id="add_quick_image"><span class="wp-media-buttons-icon"></span> ' . __( 'Add Image', 'catalog-me' ) . '</a>';
	}
	$content .= '</div>';
	return $content;
}
