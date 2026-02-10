<?php
/**
 * CORS Configuration
 *
 * Configures Cross-Origin Resource Sharing (CORS) headers
 * to allow the Next.js frontend to access the WordPress REST API.
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add CORS headers to REST API responses
 */
function coffeeshop_add_cors_headers() {
    // Allowed origins for different environments
    $allowed_origins = array(
        'http://localhost:3000',      // Next.js development
        'http://localhost:3001',      // Alternative port
        'http://coffee-shop.local',   // WordPress local
    );

    // Get the origin from the request
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    // Check if the origin is allowed
    if (in_array($origin, $allowed_origins)) {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-WP-Nonce');
        header('Access-Control-Allow-Credentials: true');
    }

    // Handle preflight OPTIONS request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        status_header(200);
        exit();
    }
}
add_action('rest_api_init', 'coffeeshop_add_cors_headers');

/**
 * Send CORS headers for all requests (not just REST API)
 * This ensures CORS works for image requests and other assets
 */
function coffeeshop_send_cors_headers() {
    $allowed_origins = array(
        'http://localhost:3000',
        'http://localhost:3001',
        'http://coffee-shop.local',
    );

    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    if (in_array($origin, $allowed_origins)) {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Credentials: true');
    }
}
add_action('init', 'coffeeshop_send_cors_headers');

/**
 * Remove the X-Pingback header
 * Not needed for headless setup
 */
function coffeeshop_remove_x_pingback($headers) {
    unset($headers['X-Pingback']);
    return $headers;
}
add_filter('wp_headers', 'coffeeshop_remove_x_pingback');

/**
 * Enable CORS for uploaded images
 * This ensures Next.js Image component can load WordPress media
 */
function coffeeshop_cors_on_uploaded_file($headers) {
    $allowed_origins = array(
        'http://localhost:3000',
        'http://localhost:3001',
        'http://coffee-shop.local',
    );

    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    if (in_array($origin, $allowed_origins)) {
        $headers['Access-Control-Allow-Origin'] = $origin;
        $headers['Access-Control-Allow-Credentials'] = 'true';
    }

    return $headers;
}
add_filter('wp_headers', 'coffeeshop_cors_on_uploaded_file');
