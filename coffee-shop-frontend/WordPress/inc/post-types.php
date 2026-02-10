<?php
/**
 * Custom Post Types Registration
 *
 * Registers custom post types for the coffee shop:
 * - Products (coffee_product)
 * - Menu Items (menu_item)
 * - Locations (cafe_location)
 * - Team Members (team_member)
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Products Post Type
 */
function coffeeshop_register_products() {
    $labels = array(
        'name'                  => _x('Products', 'Post type general name', 'coffeeshop'),
        'singular_name'         => _x('Product', 'Post type singular name', 'coffeeshop'),
        'menu_name'             => _x('Products', 'Admin Menu text', 'coffeeshop'),
        'name_admin_bar'        => _x('Product', 'Add New on Toolbar', 'coffeeshop'),
        'add_new'               => __('Add New', 'coffeeshop'),
        'add_new_item'          => __('Add New Product', 'coffeeshop'),
        'new_item'              => __('New Product', 'coffeeshop'),
        'edit_item'             => __('Edit Product', 'coffeeshop'),
        'view_item'             => __('View Product', 'coffeeshop'),
        'all_items'             => __('All Products', 'coffeeshop'),
        'search_items'          => __('Search Products', 'coffeeshop'),
        'parent_item_colon'     => __('Parent Products:', 'coffeeshop'),
        'not_found'             => __('No products found.', 'coffeeshop'),
        'not_found_in_trash'    => __('No products found in Trash.', 'coffeeshop'),
        'featured_image'        => _x('Product Image', 'Overrides the "Featured Image" phrase', 'coffeeshop'),
        'set_featured_image'    => _x('Set product image', 'Overrides the "Set featured image" phrase', 'coffeeshop'),
        'remove_featured_image' => _x('Remove product image', 'Overrides the "Remove featured image" phrase', 'coffeeshop'),
        'use_featured_image'    => _x('Use as product image', 'Overrides the "Use as featured image" phrase', 'coffeeshop'),
        'archives'              => _x('Product archives', 'The post type archive label', 'coffeeshop'),
        'insert_into_item'      => _x('Insert into product', 'Overrides the "Insert into post" phrase', 'coffeeshop'),
        'uploaded_to_this_item' => _x('Uploaded to this product', 'Overrides the "Uploaded to this post" phrase', 'coffeeshop'),
        'filter_items_list'     => _x('Filter products list', 'Screen reader text for the filter links', 'coffeeshop'),
        'items_list_navigation' => _x('Products list navigation', 'Screen reader text for the pagination', 'coffeeshop'),
        'items_list'            => _x('Products list', 'Screen reader text for the items list', 'coffeeshop'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'products'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-products',
        'show_in_rest'       => true,
        'rest_base'          => 'coffee_product',
        'supports'           => array('title', 'thumbnail'),
    );

    register_post_type('coffee_product', $args);
}
add_action('init', 'coffeeshop_register_products');

/**
 * Register Menu Items Post Type
 */
function coffeeshop_register_menu_items() {
    $labels = array(
        'name'                  => _x('Menu Items', 'Post type general name', 'coffeeshop'),
        'singular_name'         => _x('Menu Item', 'Post type singular name', 'coffeeshop'),
        'menu_name'             => _x('Menu', 'Admin Menu text', 'coffeeshop'),
        'name_admin_bar'        => _x('Menu Item', 'Add New on Toolbar', 'coffeeshop'),
        'add_new'               => __('Add New', 'coffeeshop'),
        'add_new_item'          => __('Add New Menu Item', 'coffeeshop'),
        'new_item'              => __('New Menu Item', 'coffeeshop'),
        'edit_item'             => __('Edit Menu Item', 'coffeeshop'),
        'view_item'             => __('View Menu Item', 'coffeeshop'),
        'all_items'             => __('All Menu Items', 'coffeeshop'),
        'search_items'          => __('Search Menu Items', 'coffeeshop'),
        'parent_item_colon'     => __('Parent Menu Items:', 'coffeeshop'),
        'not_found'             => __('No menu items found.', 'coffeeshop'),
        'not_found_in_trash'    => __('No menu items found in Trash.', 'coffeeshop'),
        'featured_image'        => _x('Menu Item Image', 'Overrides the "Featured Image" phrase', 'coffeeshop'),
        'set_featured_image'    => _x('Set menu item image', 'Overrides the "Set featured image" phrase', 'coffeeshop'),
        'remove_featured_image' => _x('Remove menu item image', 'Overrides the "Remove featured image" phrase', 'coffeeshop'),
        'use_featured_image'    => _x('Use as menu item image', 'Overrides the "Use as featured image" phrase', 'coffeeshop'),
        'archives'              => _x('Menu item archives', 'The post type archive label', 'coffeeshop'),
        'insert_into_item'      => _x('Insert into menu item', 'Overrides the "Insert into post" phrase', 'coffeeshop'),
        'uploaded_to_this_item' => _x('Uploaded to this menu item', 'Overrides the "Uploaded to this post" phrase', 'coffeeshop'),
        'filter_items_list'     => _x('Filter menu items list', 'Screen reader text for the filter links', 'coffeeshop'),
        'items_list_navigation' => _x('Menu items list navigation', 'Screen reader text for the pagination', 'coffeeshop'),
        'items_list'            => _x('Menu items list', 'Screen reader text for the items list', 'coffeeshop'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'menu'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-food',
        'show_in_rest'       => true,
        'rest_base'          => 'menu_item',
        'supports'           => array('title', 'thumbnail', 'custom-fields', 'excerpt'),
    );

    register_post_type('menu_item', $args);
}
add_action('init', 'coffeeshop_register_menu_items');

/**
 * Register Locations Post Type
 */
function coffeeshop_register_locations() {
    $labels = array(
        'name'                  => _x('Locations', 'Post type general name', 'coffeeshop'),
        'singular_name'         => _x('Location', 'Post type singular name', 'coffeeshop'),
        'menu_name'             => _x('Locations', 'Admin Menu text', 'coffeeshop'),
        'name_admin_bar'        => _x('Location', 'Add New on Toolbar', 'coffeeshop'),
        'add_new'               => __('Add New', 'coffeeshop'),
        'add_new_item'          => __('Add New Location', 'coffeeshop'),
        'new_item'              => __('New Location', 'coffeeshop'),
        'edit_item'             => __('Edit Location', 'coffeeshop'),
        'view_item'             => __('View Location', 'coffeeshop'),
        'all_items'             => __('All Locations', 'coffeeshop'),
        'search_items'          => __('Search Locations', 'coffeeshop'),
        'parent_item_colon'     => __('Parent Locations:', 'coffeeshop'),
        'not_found'             => __('No locations found.', 'coffeeshop'),
        'not_found_in_trash'    => __('No locations found in Trash.', 'coffeeshop'),
        'featured_image'        => _x('Location Image', 'Overrides the "Featured Image" phrase', 'coffeeshop'),
        'set_featured_image'    => _x('Set location image', 'Overrides the "Set featured image" phrase', 'coffeeshop'),
        'remove_featured_image' => _x('Remove location image', 'Overrides the "Remove featured image" phrase', 'coffeeshop'),
        'use_featured_image'    => _x('Use as location image', 'Overrides the "Use as featured image" phrase', 'coffeeshop'),
        'archives'              => _x('Location archives', 'The post type archive label', 'coffeeshop'),
        'insert_into_item'      => _x('Insert into location', 'Overrides the "Insert into post" phrase', 'coffeeshop'),
        'uploaded_to_this_item' => _x('Uploaded to this location', 'Overrides the "Uploaded to this post" phrase', 'coffeeshop'),
        'filter_items_list'     => _x('Filter locations list', 'Screen reader text for the filter links', 'coffeeshop'),
        'items_list_navigation' => _x('Locations list navigation', 'Screen reader text for the pagination', 'coffeeshop'),
        'items_list'            => _x('Locations list', 'Screen reader text for the items list', 'coffeeshop'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'locations'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-location',
        'show_in_rest'       => true,
        'rest_base'          => 'cafe_location',
        'supports'           => array('title', 'thumbnail'),
    );

    register_post_type('cafe_location', $args);
}
add_action('init', 'coffeeshop_register_locations');

/**
 * Register Team Members Post Type
 */
function coffeeshop_register_team_members() {
    $labels = array(
        'name'                  => _x('Team Members', 'Post type general name', 'coffeeshop'),
        'singular_name'         => _x('Team Member', 'Post type singular name', 'coffeeshop'),
        'menu_name'             => _x('Team', 'Admin Menu text', 'coffeeshop'),
        'name_admin_bar'        => _x('Team Member', 'Add New on Toolbar', 'coffeeshop'),
        'add_new'               => __('Add New', 'coffeeshop'),
        'add_new_item'          => __('Add New Team Member', 'coffeeshop'),
        'new_item'              => __('New Team Member', 'coffeeshop'),
        'edit_item'             => __('Edit Team Member', 'coffeeshop'),
        'view_item'             => __('View Team Member', 'coffeeshop'),
        'all_items'             => __('All Team Members', 'coffeeshop'),
        'search_items'          => __('Search Team Members', 'coffeeshop'),
        'parent_item_colon'     => __('Parent Team Members:', 'coffeeshop'),
        'not_found'             => __('No team members found.', 'coffeeshop'),
        'not_found_in_trash'    => __('No team members found in Trash.', 'coffeeshop'),
        'featured_image'        => _x('Team Member Photo', 'Overrides the "Featured Image" phrase', 'coffeeshop'),
        'set_featured_image'    => _x('Set member photo', 'Overrides the "Set featured image" phrase', 'coffeeshop'),
        'remove_featured_image' => _x('Remove member photo', 'Overrides the "Remove featured image" phrase', 'coffeeshop'),
        'use_featured_image'    => _x('Use as member photo', 'Overrides the "Use as featured image" phrase', 'coffeeshop'),
        'archives'              => _x('Team member archives', 'The post type archive label', 'coffeeshop'),
        'insert_into_item'      => _x('Insert into team member', 'Overrides the "Insert into post" phrase', 'coffeeshop'),
        'uploaded_to_this_item' => _x('Uploaded to this team member', 'Overrides the "Uploaded to this post" phrase', 'coffeeshop'),
        'filter_items_list'     => _x('Filter team members list', 'Screen reader text for the filter links', 'coffeeshop'),
        'items_list_navigation' => _x('Team members list navigation', 'Screen reader text for the pagination', 'coffeeshop'),
        'items_list'            => _x('Team members list', 'Screen reader text for the items list', 'coffeeshop'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'team'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
        'rest_base'          => 'team_member',
        'supports'           => array('title', 'thumbnail'),
    );

    register_post_type('team_member', $args);
}
add_action('init', 'coffeeshop_register_team_members');
