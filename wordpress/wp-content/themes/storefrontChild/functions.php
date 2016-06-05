<?php
add_action( 'init', 'remove_widgets' );
function remove_widgets() {
    remove_action( 'storefront_header', 'storefront_primary_navigation', 50 );
    remove_action( 'storefront_header', 'storefront_secondary_navigation', 30);
    /*remove_action( 'storefront_header', 'storefront_product_search', 40 );*/
    remove_action( 'storefront_header', 'storefront_header_cart', 60 );
}

add_action( 'storefront_header', 'storefront_header_cart', 40 );


if (function_exists('register_nav_menus')) {
    register_nav_menus(array('main-menu' => 'Main Navigation'));
}
