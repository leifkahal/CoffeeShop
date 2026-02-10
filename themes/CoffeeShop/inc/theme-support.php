<?php
/**
 * Theme Support
 *
 * Sets up WordPress theme features and support.
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme setup
 */
function coffeeshop_theme_support() {
    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Set custom thumbnail sizes for different post types
    add_image_size('product-thumbnail', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('menu-item-thumbnail', 300, 300, true);
    add_image_size('location-featured', 1200, 600, true);
    add_image_size('team-member-photo', 400, 400, true);

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'script',
        'style',
    ));

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Add support for responsive embedded content
    add_theme_support('responsive-embeds');

    // Add support for editor styles
    add_theme_support('editor-styles');

    // Register navigation menus (even though headless, useful for content organization)
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'coffeeshop'),
        'footer'  => __('Footer Menu', 'coffeeshop'),
    ));
}
add_action('after_setup_theme', 'coffeeshop_theme_support');

/**
 * Remove unnecessary WordPress features for headless setup
 */
function coffeeshop_remove_unnecessary_features() {
    // Remove emoji scripts (not needed for headless)
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');

    // Remove Windows Live Writer manifest link
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove the WordPress version from RSS feeds
    remove_action('wp_head', 'wp_generator');

    // Remove RSD link
    remove_action('wp_head', 'rsd_link');

    // Remove shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');

    // Remove REST API link tag (not needed, REST API is still accessible)
    remove_action('wp_head', 'rest_output_link_wp_head');

    // Remove oEmbed discovery links
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed REST API route
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Remove the REST API lines from the HTML Header
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}
add_action('after_setup_theme', 'coffeeshop_remove_unnecessary_features');

/**
 * Enqueue admin styles for meta boxes
 */
function coffeeshop_admin_styles() {
    echo '<style>
        .form-table th { width: 200px; padding: 15px 10px; font-weight: 600; }
        .form-table td { padding: 15px 10px; }
        .form-table input[type="text"],
        .form-table input[type="email"],
        .form-table input[type="tel"],
        .form-table input[type="number"],
        .form-table textarea,
        .form-table select { width: 100%; max-width: 500px; }
        .form-table h3 { margin: 20px 0 10px 0; padding-top: 20px; border-top: 1px solid #ddd; }
        .form-table h3:first-child { margin-top: 0; padding-top: 0; border-top: none; }
    </style>';
}
add_action('admin_head', 'coffeeshop_admin_styles');

/**
 * Add featured image support to REST API
 */
function coffeeshop_add_featured_image_to_rest() {
    // Add featured image URL to all post types
    register_rest_field(
        array('coffee_product', 'menu_item', 'cafe_location', 'team_member'),
        'featured_image_url',
        array(
            'get_callback' => function($post) {
                return array(
                    'thumbnail' => get_the_post_thumbnail_url($post['id'], 'thumbnail'),
                    'medium'    => get_the_post_thumbnail_url($post['id'], 'medium'),
                    'large'     => get_the_post_thumbnail_url($post['id'], 'large'),
                    'full'      => get_the_post_thumbnail_url($post['id'], 'full'),
                );
            },
            'schema' => null,
        )
    );
}
add_action('rest_api_init', 'coffeeshop_add_featured_image_to_rest');

/**
 * Increase REST API results per page limit
 * Useful for fetching all products/menu items at once
 */
function coffeeshop_rest_api_per_page() {
    return 100;
}
add_filter('rest_post_query', function($args) {
    if (!isset($args['posts_per_page'])) {
        $args['posts_per_page'] = 100;
    }
    return $args;
});
