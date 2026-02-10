<?php
/**
 * REST API Customizations
 *
 * Custom REST API endpoints for the CoffeeShop Next.js frontend.
 *
 * All endpoints use the namespace 'coffee-shop/v1' and return complete
 * product/menu data with all custom meta fields.
 *
 * CRITICAL: If endpoints return 404, verify this file is:
 * 1. Present in themes/CoffeeShop/inc/rest-api.php
 * 2. Included in themes/CoffeeShop/functions.php via:
 *    require_once get_template_directory() . '/inc/rest-api.php';
 *
 * @package CoffeeShop
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register custom REST API routes
 */
function coffeeshop_register_rest_routes() {
    // Menu endpoint - grouped by category
    register_rest_route('coffee-shop/v1', '/menu', array(
        'methods'  => 'GET',
        'callback' => 'coffeeshop_get_menu',
        'permission_callback' => '__return_true',
    ));

    // All products endpoint
    register_rest_route('coffee-shop/v1', '/products', array(
        'methods'  => 'GET',
        'callback' => 'coffeeshop_get_all_products',
        'permission_callback' => '__return_true',
    ));

    // Featured products endpoint
    register_rest_route('coffee-shop/v1', '/products/featured', array(
        'methods'  => 'GET',
        'callback' => 'coffeeshop_get_featured_products',
        'permission_callback' => '__return_true',
    ));

    // All locations endpoint
    register_rest_route('coffee-shop/v1', '/locations', array(
        'methods'  => 'GET',
        'callback' => 'coffeeshop_get_all_locations',
        'permission_callback' => '__return_true',
    ));

    // Locations nearest endpoint (placeholder for future implementation)
    register_rest_route('coffee-shop/v1', '/locations/nearest', array(
        'methods'  => 'GET',
        'callback' => 'coffeeshop_get_nearest_location',
        'permission_callback' => '__return_true',
    ));
}
add_action('rest_api_init', 'coffeeshop_register_rest_routes');

/**
 * Get menu items grouped by category
 */
function coffeeshop_get_menu() {
    $args = array(
        'post_type'      => 'menu_item',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    $menu_items = get_posts($args);

    $menu = array(
        'hot'  => array(),
        'cold' => array(),
        'food' => array(),
    );

    foreach ($menu_items as $item) {
        $category = get_post_meta($item->ID, 'category', true) ?: 'hot';

        $menu_item_data = array(
            'id'      => $item->ID,
            'title'   => array('rendered' => $item->post_title),
            'slug'    => $item->post_name,
            'content' => array('rendered' => apply_filters('the_content', $item->post_content)),
            'excerpt' => array('rendered' => $item->post_excerpt),
            'image'   => get_the_post_thumbnail_url($item->ID, 'medium'),
            'meta'    => array(
                'price'        => (float) get_post_meta($item->ID, 'price', true),
                'ingredients'  => get_post_meta($item->ID, 'ingredients', true),
                'allergens'    => get_post_meta($item->ID, 'allergens', true),
                'availability' => get_post_meta($item->ID, 'availability', true),
                'category'     => get_post_meta($item->ID, 'category', true),
            ),
        );

        $menu[$category][] = $menu_item_data;
    }

    return rest_ensure_response($menu);
}

/**
 * Get all products
 *
 * Returns ALL published coffee products with complete metadata.
 * Used by the frontend /products page to display all available coffee beans.
 *
 * This endpoint was added Feb 9, 2025 to fix products page not displaying
 * product details (price, roast level, origin). The standard WordPress REST
 * API endpoint (/wp/v2/coffee_product) does not include meta fields, so we
 * provide this custom endpoint with all necessary data.
 *
 * Frontend call: src/lib/wordpress.ts getProducts()
 * Frontend usage: src/app/products/page.tsx
 *
 * @return WP_REST_Response Array of all products with metadata
 */
function coffeeshop_get_all_products() {
    $args = array(
        'post_type'      => 'coffee_product',
        'post_status'    => 'publish',
        'posts_per_page' => -1, // Get all products
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $products = get_posts($args);
    $all_products = array();

    foreach ($products as $product) {
        $all_products[] = array(
            'id'    => $product->ID,
            'slug'  => $product->post_name,
            'title' => array('rendered' => $product->post_title),
            'content' => array('rendered' => $product->post_content),
            'excerpt' => array('rendered' => $product->post_excerpt),
            'featured_image_url' => array(
                'thumbnail' => get_the_post_thumbnail_url($product->ID, 'thumbnail'),
                'medium'    => get_the_post_thumbnail_url($product->ID, 'medium'),
                'large'     => get_the_post_thumbnail_url($product->ID, 'large'),
                'full'      => get_the_post_thumbnail_url($product->ID, 'full'),
            ),
            'meta' => array(
                'price'            => (float) get_post_meta($product->ID, 'price', true),
                'sku'              => get_post_meta($product->ID, 'sku', true),
                'roast_level'      => get_post_meta($product->ID, 'roast_level', true),
                'origin'           => get_post_meta($product->ID, 'origin', true),
                'tasting_notes'    => get_post_meta($product->ID, 'tasting_notes', true),
                'stock_status'     => get_post_meta($product->ID, 'stock_status', true),
                'featured_product' => (bool) get_post_meta($product->ID, 'featured_product', true),
            ),
        );
    }

    return rest_ensure_response($all_products);
}

/**
 * Get featured products
 */
function coffeeshop_get_featured_products() {
    $args = array(
        'post_type'      => 'coffee_product',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => 'featured_product',
                'value' => '1',
            ),
        ),
    );

    $products = get_posts($args);
    $featured = array();

    foreach ($products as $product) {
        $featured[] = array(
            'id'    => $product->ID,
            'slug'  => $product->post_name,
            'title' => array('rendered' => $product->post_title),
            'content' => array('rendered' => $product->post_content),
            'excerpt' => array('rendered' => $product->post_excerpt),
            'featured_image_url' => array(
                'thumbnail' => get_the_post_thumbnail_url($product->ID, 'thumbnail'),
                'medium'    => get_the_post_thumbnail_url($product->ID, 'medium'),
                'large'     => get_the_post_thumbnail_url($product->ID, 'large'),
                'full'      => get_the_post_thumbnail_url($product->ID, 'full'),
            ),
            'meta' => array(
                'price'            => (float) get_post_meta($product->ID, 'price', true),
                'sku'              => get_post_meta($product->ID, 'sku', true),
                'roast_level'      => get_post_meta($product->ID, 'roast_level', true),
                'origin'           => get_post_meta($product->ID, 'origin', true),
                'tasting_notes'    => get_post_meta($product->ID, 'tasting_notes', true),
                'stock_status'     => get_post_meta($product->ID, 'stock_status', true),
                'featured_product' => true,
            ),
        );
    }

    return rest_ensure_response($featured);
}

/**
 * Get all locations
 *
 * Returns ALL published café locations with complete metadata including
 * address, phone, email, hours, and coordinates.
 * Used by the frontend /locations page.
 *
 * This endpoint was added Feb 9, 2025 to fix locations page not displaying
 * location details. The standard WordPress REST API endpoint (/wp/v2/cafe_location)
 * does not include meta fields.
 *
 * Frontend call: src/lib/wordpress.ts getLocations()
 * Frontend usage: src/app/locations/page.tsx
 *
 * @return WP_REST_Response Array of all locations with metadata
 */
function coffeeshop_get_all_locations() {
    $args = array(
        'post_type'      => 'cafe_location',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );

    $locations = get_posts($args);
    $all_locations = array();

    foreach ($locations as $location) {
        $all_locations[] = array(
            'id'      => $location->ID,
            'slug'    => $location->post_name,
            'title'   => array('rendered' => $location->post_title),
            'content' => array('rendered' => $location->post_content),
            'excerpt' => array('rendered' => $location->post_excerpt),
            'featured_image_url' => array(
                'thumbnail' => get_the_post_thumbnail_url($location->ID, 'thumbnail'),
                'medium'    => get_the_post_thumbnail_url($location->ID, 'medium'),
                'large'     => get_the_post_thumbnail_url($location->ID, 'large'),
                'full'      => get_the_post_thumbnail_url($location->ID, 'full'),
            ),
            'meta' => array(
                'address_street' => get_post_meta($location->ID, 'address_street', true),
                'address_city'   => get_post_meta($location->ID, 'address_city', true),
                'address_state'  => get_post_meta($location->ID, 'address_state', true),
                'address_zip'    => get_post_meta($location->ID, 'address_zip', true),
                'phone'          => get_post_meta($location->ID, 'phone', true),
                'email'          => get_post_meta($location->ID, 'email', true),
                'hours'          => get_post_meta($location->ID, 'hours', true),
                'latitude'       => get_post_meta($location->ID, 'latitude', true),
                'longitude'      => get_post_meta($location->ID, 'longitude', true),
            ),
        );
    }

    return rest_ensure_response($all_locations);
}

/**
 * Get nearest location (placeholder for future implementation with coordinates)
 */
function coffeeshop_get_nearest_location($request) {
    // This is a placeholder. In a real implementation, you would:
    // 1. Get latitude and longitude from request parameters
    // 2. Calculate distance to all locations
    // 3. Return the nearest one

    $args = array(
        'post_type'      => 'cafe_location',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
    );

    $locations = get_posts($args);

    if (empty($locations)) {
        return new WP_Error('no_locations', 'No locations found', array('status' => 404));
    }

    $location = $locations[0];
    $location_data = array(
        'id'           => $location->ID,
        'title'        => $location->post_title,
        'slug'         => $location->post_name,
        'description'  => $location->post_content,
        'image'        => get_the_post_thumbnail_url($location->ID, 'medium'),
        'address'      => array(
            'street' => get_post_meta($location->ID, 'address_street', true),
            'city'   => get_post_meta($location->ID, 'address_city', true),
            'state'  => get_post_meta($location->ID, 'address_state', true),
            'zip'    => get_post_meta($location->ID, 'address_zip', true),
        ),
        'phone'        => get_post_meta($location->ID, 'phone', true),
        'email'        => get_post_meta($location->ID, 'email', true),
        'hours'        => get_post_meta($location->ID, 'hours', true),
        'coordinates'  => array(
            'latitude'  => get_post_meta($location->ID, 'latitude', true),
            'longitude' => get_post_meta($location->ID, 'longitude', true),
        ),
    );

    return rest_ensure_response($location_data);
}

/**
 * Add meta fields to REST API response
 * This ensures all custom meta fields are included in the standard endpoints
 */
function coffeeshop_add_meta_to_rest_api() {
    // This is already handled by register_post_meta() with show_in_rest => true
    // But we can add additional customizations here if needed
}
add_action('rest_api_init', 'coffeeshop_add_meta_to_rest_api');
