<?php
/**
 * CoffeeShop Headless Theme Functions
 *
 * Main theme functions file. Loads all includes and sets up the headless WordPress theme.
 *
 * @package CoffeeShop
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Theme version
 */
define('COFFEESHOP_VERSION', '1.0.0');

/**
 * Theme directory path
 */
define('COFFEESHOP_DIR', get_template_directory());

/**
 * Theme directory URI
 */
define('COFFEESHOP_URI', get_template_directory_uri());

/**
 * Load theme includes
 *
 * The includes directory contains all the theme's functionality split into logical files:
 * - post-types.php: Custom post type registrations
 * - meta-boxes.php: Custom meta boxes and fields
 * - rest-api.php: Custom REST API endpoints
 * - cors.php: CORS configuration for headless setup
 * - theme-support.php: WordPress theme support and features
 */
function coffeeshop_load_includes() {
    $includes = array(
        'inc/theme-support.php', // Load first - sets up theme support
        'inc/post-types.php',    // Custom post types
        'inc/meta-boxes.php',    // Custom meta boxes
        'inc/rest-api.php',      // REST API customizations
        'inc/cors.php',          // CORS configuration
        'inc/sample-data.php',   // Sample data generator
    );

    foreach ($includes as $file) {
        $filepath = COFFEESHOP_DIR . '/' . $file;
        if (file_exists($filepath)) {
            require_once $filepath;
        } else {
            // Log error if file doesn't exist (useful for debugging)
            error_log(sprintf('CoffeeShop Theme: Required file not found: %s', $filepath));
        }
    }
}
add_action('after_setup_theme', 'coffeeshop_load_includes', 5);

/**
 * Flush rewrite rules on theme activation
 * This ensures custom post type permalinks work correctly
 */
function coffeeshop_activation() {
    // Load includes so post types are registered
    coffeeshop_load_includes();

    // Flush rewrite rules
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'coffeeshop_activation');

/**
 * Flush rewrite rules on theme deactivation
 */
function coffeeshop_deactivation() {
    flush_rewrite_rules();
}
add_action('switch_theme', 'coffeeshop_deactivation');

/**
 * Admin notice for headless theme
 * Displays a notice in the WordPress admin to inform users this is a headless theme
 */
function coffeeshop_admin_notice() {
    $screen = get_current_screen();

    // Only show on dashboard and themes pages
    if (!in_array($screen->id, array('dashboard', 'themes'))) {
        return;
    }

    ?>
    <div class="notice notice-info is-dismissible">
        <p>
            <strong>☕ CoffeeShop Headless Theme Active</strong><br>
            This is a headless WordPress theme. Content is managed here and displayed via the Next.js frontend.<br>
            <a href="<?php echo esc_url(rest_url()); ?>" target="_blank">View REST API</a> |
            <a href="http://localhost:3000" target="_blank">View Frontend (Next.js)</a>
        </p>
    </div>
    <?php
}
add_action('admin_notices', 'coffeeshop_admin_notice');

/**
 * Remove frontend scripts (not needed for headless setup)
 * This theme doesn't need any frontend JavaScript or CSS
 */
function coffeeshop_remove_frontend_scripts() {
    // Remove jQuery (not needed)
    wp_deregister_script('jquery');

    // Remove WordPress embed script
    wp_deregister_script('wp-embed');
}
add_action('wp_enqueue_scripts', 'coffeeshop_remove_frontend_scripts', 100);

/**
 * Enable REST API for anonymous users (required for headless)
 */
add_filter('rest_authentication_errors', function($result) {
    // If a previous authentication check was applied, respect it
    if (true === $result || is_wp_error($result)) {
        return $result;
    }
    // Allow anonymous access to REST API
    return true;
});

/**
 * Disable XML-RPC (security best practice for headless)
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Disable application passwords for headless setup (optional)
 * Comment out if you need application passwords for authentication
 */
// add_filter('wp_is_application_passwords_available', '__return_false');

/**
 * Add helpful links to admin bar
 */
function coffeeshop_admin_bar_links($wp_admin_bar) {
    // Add REST API link
    $wp_admin_bar->add_node(array(
        'id'    => 'rest-api',
        'title' => '🔗 REST API',
        'href'  => rest_url(),
        'meta'  => array('target' => '_blank'),
    ));

    // Add Next.js frontend link
    $wp_admin_bar->add_node(array(
        'id'    => 'nextjs-frontend',
        'title' => '⚡ Next.js Frontend',
        'href'  => 'http://localhost:3000',
        'meta'  => array('target' => '_blank'),
    ));

    // Add custom endpoints submenu
    $wp_admin_bar->add_node(array(
        'id'     => 'custom-endpoints',
        'parent' => 'rest-api',
        'title'  => 'Custom Endpoints',
    ));

    $wp_admin_bar->add_node(array(
        'id'     => 'endpoint-menu',
        'parent' => 'custom-endpoints',
        'title'  => 'Menu (Grouped)',
        'href'   => rest_url('coffee-shop/v1/menu'),
        'meta'   => array('target' => '_blank'),
    ));

    $wp_admin_bar->add_node(array(
        'id'     => 'endpoint-featured',
        'parent' => 'custom-endpoints',
        'title'  => 'Featured Products',
        'href'   => rest_url('coffee-shop/v1/products/featured'),
        'meta'   => array('target' => '_blank'),
    ));
}
add_action('admin_bar_menu', 'coffeeshop_admin_bar_links', 100);

/**
 * Theme info dashboard widget
 */
function coffeeshop_dashboard_widget() {
    wp_add_dashboard_widget(
        'coffeeshop_info',
        '☕ CoffeeShop Theme Info',
        'coffeeshop_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'coffeeshop_dashboard_widget');

/**
 * Dashboard widget content
 */
function coffeeshop_dashboard_widget_content() {
    ?>
    <div style="font-size: 14px;">
        <p><strong>Theme:</strong> CoffeeShop Headless v<?php echo COFFEESHOP_VERSION; ?></p>
        <p><strong>Architecture:</strong> Headless WordPress + Next.js</p>

        <h4 style="margin-top: 20px;">📦 Custom Post Types:</h4>
        <ul style="margin-left: 20px;">
            <li>Products (Coffee Beans, Merchandise)</li>
            <li>Menu Items (Drinks, Food)</li>
            <li>Locations (Store Addresses)</li>
            <li>Team Members (Staff Profiles)</li>
        </ul>

        <h4 style="margin-top: 20px;">🔗 Quick Links:</h4>
        <ul style="margin-left: 20px;">
            <li><a href="<?php echo rest_url(); ?>" target="_blank">REST API Root</a></li>
            <li><a href="<?php echo rest_url('coffee-shop/v1/menu'); ?>" target="_blank">Menu API</a></li>
            <li><a href="<?php echo rest_url('wp/v2/coffee_product'); ?>" target="_blank">Products API</a></li>
            <li><a href="http://localhost:3000" target="_blank">Next.js Frontend</a></li>
        </ul>

        <p style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd; color: #666;">
            <small>Content managed in WordPress, displayed via Next.js frontend.</small>
        </p>
    </div>
    <?php
}

/**
 * Debug info (for development only)
 * Uncomment to display debug information in admin footer
 */
// function coffeeshop_debug_info() {
//     if (current_user_can('manage_options')) {
//         echo '<div style="margin-top: 20px; padding: 10px; background: #f0f0f0; border: 1px solid #ccc;">';
//         echo '<strong>Debug Info:</strong><br>';
//         echo 'WordPress Version: ' . get_bloginfo('version') . '<br>';
//         echo 'Theme Version: ' . COFFEESHOP_VERSION . '<br>';
//         echo 'REST API URL: ' . rest_url() . '<br>';
//         echo 'Active Post Types: ' . implode(', ', get_post_types(array('public' => true))) . '<br>';
//         echo '</div>';
//     }
// }
// add_action('admin_footer', 'coffeeshop_debug_info');
