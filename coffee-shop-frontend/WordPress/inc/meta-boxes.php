<?php
/**
 * Custom Meta Boxes
 *
 * Registers custom meta boxes and fields for all custom post types.
 * All fields are exposed in the REST API via register_post_meta().
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Product Meta Fields
 */
function coffeeshop_register_product_meta() {
    // Price
    register_post_meta('coffee_product', 'price', array(
        'type'         => 'number',
        'description'  => 'Product price',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 0,
    ));

    // SKU
    register_post_meta('coffee_product', 'sku', array(
        'type'         => 'string',
        'description'  => 'Product SKU',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Roast Level
    register_post_meta('coffee_product', 'roast_level', array(
        'type'         => 'string',
        'description'  => 'Coffee roast level',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 'medium',
    ));

    // Origin
    register_post_meta('coffee_product', 'origin', array(
        'type'         => 'string',
        'description'  => 'Coffee origin/region',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Tasting Notes
    register_post_meta('coffee_product', 'tasting_notes', array(
        'type'         => 'string',
        'description'  => 'Product tasting notes',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Stock Status
    register_post_meta('coffee_product', 'stock_status', array(
        'type'         => 'string',
        'description'  => 'Product stock status',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 'in-stock',
    ));

    // Featured Product
    register_post_meta('coffee_product', 'featured_product', array(
        'type'         => 'boolean',
        'description'  => 'Is this a featured product',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => false,
    ));

    // Description
    register_post_meta('coffee_product', 'description', array(
        'type'         => 'string',
        'description'  => 'Product description',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));
}
add_action('init', 'coffeeshop_register_product_meta');

/**
 * Register Menu Item Meta Fields
 */
function coffeeshop_register_menu_item_meta() {
    // Category
    register_post_meta('menu_item', 'category', array(
        'type'         => 'string',
        'description'  => 'Menu item category',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 'hot',
    ));

    // Price
    register_post_meta('menu_item', 'price', array(
        'type'         => 'number',
        'description'  => 'Menu item price',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 0,
    ));

    // Ingredients
    register_post_meta('menu_item', 'ingredients', array(
        'type'         => 'string',
        'description'  => 'Menu item ingredients',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Allergens
    register_post_meta('menu_item', 'allergens', array(
        'type'         => 'string',
        'description'  => 'Menu item allergens (comma-separated)',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Availability
    register_post_meta('menu_item', 'availability', array(
        'type'         => 'string',
        'description'  => 'Menu item availability (comma-separated)',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 'all-day',
    ));

    // Featured Menu Item
    register_post_meta('menu_item', 'featured_menu_item', array(
        'type'         => 'boolean',
        'description'  => 'Is this a featured menu item',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => false,
    ));

    // Description
    register_post_meta('menu_item', 'description', array(
        'type'         => 'string',
        'description'  => 'Menu item description',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));
}
add_action('init', 'coffeeshop_register_menu_item_meta');

/**
 * Register Location Meta Fields
 */
function coffeeshop_register_location_meta() {
    // Address fields
    register_post_meta('cafe_location', 'address_street', array(
        'type'         => 'string',
        'description'  => 'Street address',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('cafe_location', 'address_city', array(
        'type'         => 'string',
        'description'  => 'City',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('cafe_location', 'address_state', array(
        'type'         => 'string',
        'description'  => 'State',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('cafe_location', 'address_zip', array(
        'type'         => 'string',
        'description'  => 'ZIP code',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Contact fields
    register_post_meta('cafe_location', 'phone', array(
        'type'         => 'string',
        'description'  => 'Phone number',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('cafe_location', 'email', array(
        'type'         => 'string',
        'description'  => 'Email address',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Hours
    register_post_meta('cafe_location', 'hours', array(
        'type'         => 'string',
        'description'  => 'Opening hours',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Map coordinates
    register_post_meta('cafe_location', 'latitude', array(
        'type'         => 'string',
        'description'  => 'Latitude',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('cafe_location', 'longitude', array(
        'type'         => 'string',
        'description'  => 'Longitude',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));
}
add_action('init', 'coffeeshop_register_location_meta');

/**
 * Register Team Member Meta Fields
 */
function coffeeshop_register_team_member_meta() {
    // Position
    register_post_meta('team_member', 'position', array(
        'type'         => 'string',
        'description'  => 'Job position',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Bio
    register_post_meta('team_member', 'bio', array(
        'type'         => 'string',
        'description'  => 'Team member bio',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Social links
    register_post_meta('team_member', 'instagram', array(
        'type'         => 'string',
        'description'  => 'Instagram handle',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('team_member', 'twitter', array(
        'type'         => 'string',
        'description'  => 'Twitter handle',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    register_post_meta('team_member', 'linkedin', array(
        'type'         => 'string',
        'description'  => 'LinkedIn URL',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));

    // Email
    register_post_meta('team_member', 'email', array(
        'type'         => 'string',
        'description'  => 'Team member email',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => '',
    ));
}
add_action('init', 'coffeeshop_register_team_member_meta');

/**
 * Remove Custom Fields and Standard Meta Boxes for Coffee Shop CPTs
 */
function coffeeshop_remove_meta_boxes() {
    $cpts = array('coffee_product', 'menu_item', 'cafe_location', 'team_member');

    foreach ($cpts as $cpt) {
        // Remove the custom fields meta box
        remove_meta_box('postcustom', $cpt, 'normal');
    }
}
add_action('do_meta_boxes', 'coffeeshop_remove_meta_boxes');


/**
 * Set default screen options for meta boxes
 */
function coffeeshop_default_screen_options($screen_options, $screen) {
    if ($screen->post_type === 'menu_item') {
        // Set postimagediv as visible by default
        if (!isset($screen_options['postimagediv'])) {
            $screen_options['postimagediv'] = 'on';
        }
    }
    return $screen_options;
}
add_filter('default_hidden_meta_boxes', 'coffeeshop_default_screen_options', 10, 2);

/**
 * Enqueue admin CSS and JavaScript
 */
function coffeeshop_enqueue_admin_styles($hook) {
    // Only load on post edit pages
    if ($hook !== 'post.php' && $hook !== 'post-new.php') {
        return;
    }

    global $post;
    if (!$post) {
        return;
    }

    $cpts = array('coffee_product', 'menu_item', 'cafe_location', 'team_member');
    if (!in_array($post->post_type, $cpts)) {
        return;
    }

    // Use file modification time for cache busting
    $css_file = get_template_directory() . '/admin.min.css';
    $css_version = file_exists($css_file) ? md5_file($css_file) : COFFEESHOP_VERSION;
    wp_enqueue_style('coffeeshop-admin', get_template_directory_uri() . '/admin.min.css', array(), $css_version, 'all');

    if (file_exists(get_template_directory() . '/admin.js')) {
        $js_file = get_template_directory() . '/admin.js';
        $js_version = filemtime($js_file);
        wp_enqueue_script('coffeeshop-admin', get_template_directory_uri() . '/admin.js', array(), $js_version, true);
    }
}
add_action('admin_enqueue_scripts', 'coffeeshop_enqueue_admin_styles', 10, 1);

/**
 * Add CSS and JavaScript to hide standard editor and make meta boxes default to open
 */
function coffeeshop_meta_box_styles() {
    global $post;

    $cpts = array('coffee_product', 'menu_item', 'cafe_location', 'team_member');
    $is_coffee_cpt = $post && in_array($post->post_type, $cpts);

    if (!$is_coffee_cpt) {
        return;
    }
    ?>
    <style>
        /* Hide WordPress editor for coffee shop CPTs */
        #postexcerpt,
        #post-status-info {
            display: none !important;
        }

        /* Keep meta boxes open and styled */
        .postbox {
            margin-bottom: 20px;
        }
        .postbox.closed {
            display: none;
        }

        /* Keep slug box closed by default */
        #slugdiv.closed {
            display: block;
        }
    </style>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Close slug box by default
            var slugBox = document.getElementById('slugdiv');
            if (slugBox) {
                slugBox.classList.add('closed');
            }

            // Ensure all coffee shop meta boxes are open on load
            var metaBoxes = document.querySelectorAll('.postbox');
            metaBoxes.forEach(function(box) {
                // Skip slug box, keep it closed
                if (box.id === 'slugdiv') {
                    return;
                }
                // Remove closed class to keep boxes open
                box.classList.remove('closed');
            });

            // Disable toggling meta boxes for coffee shop CPTs
            if (document.body.classList.contains('post-type-coffee_product') ||
                document.body.classList.contains('post-type-menu_item') ||
                document.body.classList.contains('post-type-cafe_location') ||
                document.body.classList.contains('post-type-team_member')) {

                metaBoxes.forEach(function(box) {
                    // Allow slug box to be toggled
                    if (box.id === 'slugdiv') {
                        return;
                    }

                    var toggle = box.querySelector('.handlediv');
                    if (toggle) {
                        toggle.style.cursor = 'default';
                        toggle.onclick = function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                        };
                    }
                });
            }
        });
    </script>
    <?php
}
add_action('admin_head-post.php', 'coffeeshop_meta_box_styles');
add_action('admin_head-post-new.php', 'coffeeshop_meta_box_styles');

/**
 * Add Product Meta Box
 */
function coffeeshop_add_product_meta_box() {
    add_meta_box(
        'product_details',
        __('Product Details', 'coffeeshop'),
        'coffeeshop_product_meta_box_html',
        'coffee_product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_product_meta_box');

/**
 * Product Meta Box HTML
 */
function coffeeshop_product_meta_box_html($post) {
    wp_nonce_field('coffeeshop_product_meta_box', 'coffeeshop_product_meta_box_nonce');

    $description = get_post_meta($post->ID, 'description', true);
    $price = get_post_meta($post->ID, 'price', true);
    $sku = get_post_meta($post->ID, 'sku', true);
    $roast_level = get_post_meta($post->ID, 'roast_level', true) ?: 'medium';
    $origin = get_post_meta($post->ID, 'origin', true);
    $tasting_notes = get_post_meta($post->ID, 'tasting_notes', true);
    $stock_status = get_post_meta($post->ID, 'stock_status', true) ?: 'in-stock';
    $featured = get_post_meta($post->ID, 'featured_product', true);
    ?>
    <div style="padding: 10px;">
        <p>
            <label for="product_description" style="display: block; margin-bottom: 5px;"><strong><?php _e('Description', 'coffeeshop'); ?></strong></label>
            <textarea id="product_description" name="product_description" rows="4" class="large-text" style="width: 100%;"><?php echo esc_textarea($description); ?></textarea>
        </p>

        <p>
            <label for="product_price" style="display: block; margin-bottom: 5px;"><strong><?php _e('Price ($)', 'coffeeshop'); ?></strong></label>
            <input type="number" step="0.01" id="product_price" name="product_price" value="<?php echo esc_attr($price); ?>" class="regular-text" />
        </p>

        <p>
            <label for="product_sku" style="display: block; margin-bottom: 5px;"><strong><?php _e('SKU', 'coffeeshop'); ?></strong></label>
            <input type="text" id="product_sku" name="product_sku" value="<?php echo esc_attr($sku); ?>" class="regular-text" />
        </p>

        <p>
            <label for="product_roast_level" style="display: block; margin-bottom: 5px;"><strong><?php _e('Roast Level', 'coffeeshop'); ?></strong></label>
            <select id="product_roast_level" name="product_roast_level" style="width: 100%;">
                <option value="light" <?php selected($roast_level, 'light'); ?>><?php _e('Light', 'coffeeshop'); ?></option>
                <option value="medium" <?php selected($roast_level, 'medium'); ?>><?php _e('Medium', 'coffeeshop'); ?></option>
                <option value="dark" <?php selected($roast_level, 'dark'); ?>><?php _e('Dark', 'coffeeshop'); ?></option>
            </select>
        </p>

        <p>
            <label for="product_origin" style="display: block; margin-bottom: 5px;"><strong><?php _e('Origin', 'coffeeshop'); ?></strong></label>
            <input type="text" id="product_origin" name="product_origin" value="<?php echo esc_attr($origin); ?>" class="regular-text" placeholder="e.g., Ethiopia, Colombia" />
        </p>

        <p>
            <label for="product_tasting_notes" style="display: block; margin-bottom: 5px;"><strong><?php _e('Tasting Notes', 'coffeeshop'); ?></strong></label>
            <textarea id="product_tasting_notes" name="product_tasting_notes" rows="3" class="large-text" style="width: 100%;"><?php echo esc_textarea($tasting_notes); ?></textarea>
        </p>

        <p>
            <label style="display: block; margin-bottom: 5px;"><strong><?php _e('Stock Status', 'coffeeshop'); ?></strong></label>
            <label><input type="radio" name="product_stock_status" value="in-stock" <?php checked($stock_status, 'in-stock'); ?> /> <?php _e('In Stock', 'coffeeshop'); ?></label><br>
            <label><input type="radio" name="product_stock_status" value="out-of-stock" <?php checked($stock_status, 'out-of-stock'); ?> /> <?php _e('Out of Stock', 'coffeeshop'); ?></label>
        </p>

        <p>
            <label><input type="checkbox" id="product_featured" name="product_featured" value="1" <?php checked($featured, '1'); ?> /> <?php _e('Mark as featured', 'coffeeshop'); ?></label>
        </p>
    </div>
    <?php
}

/**
 * Save Product Meta Box Data
 */
function coffeeshop_save_product_meta_box($post_id) {
    if (!isset($_POST['coffeeshop_product_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['coffeeshop_product_meta_box_nonce'], 'coffeeshop_product_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['product_description'])) {
        update_post_meta($post_id, 'description', sanitize_textarea_field($_POST['product_description']));
    }
    if (isset($_POST['product_price'])) {
        update_post_meta($post_id, 'price', floatval($_POST['product_price']));
    }
    if (isset($_POST['product_sku'])) {
        update_post_meta($post_id, 'sku', sanitize_text_field($_POST['product_sku']));
    }
    if (isset($_POST['product_roast_level'])) {
        update_post_meta($post_id, 'roast_level', sanitize_text_field($_POST['product_roast_level']));
    }
    if (isset($_POST['product_origin'])) {
        update_post_meta($post_id, 'origin', sanitize_text_field($_POST['product_origin']));
    }
    if (isset($_POST['product_tasting_notes'])) {
        update_post_meta($post_id, 'tasting_notes', sanitize_textarea_field($_POST['product_tasting_notes']));
    }
    if (isset($_POST['product_stock_status'])) {
        update_post_meta($post_id, 'stock_status', sanitize_text_field($_POST['product_stock_status']));
    }
    $featured = isset($_POST['product_featured']) ? '1' : '0';
    update_post_meta($post_id, 'featured_product', $featured);
}
add_action('save_post_coffee_product', 'coffeeshop_save_product_meta_box');

/**
 * Add Menu Item Meta Box
 */
function coffeeshop_add_menu_item_meta_box() {
    add_meta_box(
        'menu_item_details',
        __('Menu Item Details', 'coffeeshop'),
        'coffeeshop_menu_item_meta_box_html',
        'menu_item',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_menu_item_meta_box');

/**
 * Menu Item Meta Box HTML
 */
function coffeeshop_menu_item_meta_box_html($post) {
    wp_nonce_field('coffeeshop_menu_item_meta_box', 'coffeeshop_menu_item_meta_box_nonce');

    $description = get_post_meta($post->ID, 'description', true);
    $category = get_post_meta($post->ID, 'category', true) ?: 'hot';
    $price = get_post_meta($post->ID, 'price', true);
    $ingredients = get_post_meta($post->ID, 'ingredients', true);
    $allergens = get_post_meta($post->ID, 'allergens', true);
    $availability = get_post_meta($post->ID, 'availability', true) ?: 'all-day';
    $featured = get_post_meta($post->ID, 'featured_menu_item', true);
    ?>
    <div style="padding: 10px;">
        <p>
            <label for="menu_description" style="display: block; margin-bottom: 5px;"><strong><?php _e('Description', 'coffeeshop'); ?></strong></label>
            <textarea id="menu_description" name="menu_description" rows="4" class="large-text" style="width: 100%;"><?php echo esc_textarea($description); ?></textarea>
        </p>

        <p>
            <label for="menu_category" style="display: block; margin-bottom: 5px;"><strong><?php _e('Category', 'coffeeshop'); ?></strong></label>
            <select id="menu_category" name="menu_category" style="width: 100%;">
                <option value="hot" <?php selected($category, 'hot'); ?>><?php _e('Hot Drinks', 'coffeeshop'); ?></option>
                <option value="cold" <?php selected($category, 'cold'); ?>><?php _e('Cold Drinks', 'coffeeshop'); ?></option>
                <option value="food" <?php selected($category, 'food'); ?>><?php _e('Food', 'coffeeshop'); ?></option>
            </select>
        </p>

        <p>
            <label for="menu_price" style="display: block; margin-bottom: 5px;"><strong><?php _e('Price ($)', 'coffeeshop'); ?></strong></label>
            <input type="number" step="0.01" id="menu_price" name="menu_price" value="<?php echo esc_attr($price); ?>" class="regular-text" />
        </p>

        <p>
            <label for="menu_ingredients" style="display: block; margin-bottom: 5px;"><strong><?php _e('Ingredients', 'coffeeshop'); ?></strong></label>
            <textarea id="menu_ingredients" name="menu_ingredients" rows="3" class="large-text" style="width: 100%;" placeholder="e.g., Espresso, Steamed Milk, Vanilla Syrup"><?php echo esc_textarea($ingredients); ?></textarea>
        </p>

        <p>
            <label for="menu_allergens" style="display: block; margin-bottom: 5px;"><strong><?php _e('Allergens', 'coffeeshop'); ?></strong></label>
            <input type="text" id="menu_allergens" name="menu_allergens" value="<?php echo esc_attr($allergens); ?>" class="regular-text" placeholder="e.g., Dairy, Nuts (comma-separated)" />
        </p>

        <p>
            <label for="menu_availability" style="display: block; margin-bottom: 5px;"><strong><?php _e('Availability', 'coffeeshop'); ?></strong></label>
            <input type="text" id="menu_availability" name="menu_availability" value="<?php echo esc_attr($availability); ?>" class="regular-text" placeholder="e.g., all-day, breakfast, lunch (comma-separated)" />
        </p>

        <p>
            <label><input type="checkbox" id="menu_featured" name="menu_featured" value="1" <?php checked($featured, '1'); ?> /> <?php _e('Display on homepage order online section', 'coffeeshop'); ?></label>
        </p>
    </div>
    <?php
}

/**
 * Save Menu Item Meta Box Data
 */
function coffeeshop_save_menu_item_meta_box($post_id) {
    if (!isset($_POST['coffeeshop_menu_item_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['coffeeshop_menu_item_meta_box_nonce'], 'coffeeshop_menu_item_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['menu_description'])) {
        update_post_meta($post_id, 'description', sanitize_textarea_field($_POST['menu_description']));
    }
    if (isset($_POST['menu_category'])) {
        update_post_meta($post_id, 'category', sanitize_text_field($_POST['menu_category']));
    }
    if (isset($_POST['menu_price'])) {
        update_post_meta($post_id, 'price', floatval($_POST['menu_price']));
    }
    if (isset($_POST['menu_ingredients'])) {
        update_post_meta($post_id, 'ingredients', sanitize_textarea_field($_POST['menu_ingredients']));
    }
    if (isset($_POST['menu_allergens'])) {
        update_post_meta($post_id, 'allergens', sanitize_text_field($_POST['menu_allergens']));
    }
    if (isset($_POST['menu_availability'])) {
        update_post_meta($post_id, 'availability', sanitize_text_field($_POST['menu_availability']));
    }
    $featured = isset($_POST['menu_featured']) ? '1' : '0';
    update_post_meta($post_id, 'featured_menu_item', $featured);
}
add_action('save_post_menu_item', 'coffeeshop_save_menu_item_meta_box');

/**
 * Quick Edit for Menu Items - Display Field
 */
function coffeeshop_menu_item_quick_edit_custom_box($column_name, $post_type) {
    if ($post_type !== 'menu_item') {
        return;
    }
    wp_nonce_field('coffeeshop_quick_edit_nonce', '_menu_featured_nonce');
    ?>
    <fieldset class="inline-edit-col- text-center">
        <div class="inline-edit-group">
            <label>
                <input type="checkbox" name="menu_featured_quick" value="1" />
                <span class="checkbox-title"><?php _e('Featured', 'coffeeshop'); ?></span>
            </label>
        </div>
    </fieldset>
    <?php
}
add_action('quick_edit_custom_box', 'coffeeshop_menu_item_quick_edit_custom_box', 10, 2);

/**
 * Inline Edit JS - Populate Quick Edit with Data
 */
function coffeeshop_menu_item_quick_edit_javascript() {
    global $current_screen;

    if ($current_screen->post_type !== 'menu_item') {
        return;
    }

    wp_enqueue_script('coffeeshop-inline-edit', false, array('jquery', 'inline-edit-post'), false, true);
    ?>
    <script type="text/javascript">
    (function($) {
        // Copy inline edit functionality
        var $wp_inline_edit = inlineEditPost.edit;

        inlineEditPost.edit = function(id) {
            $wp_inline_edit.apply(this, arguments);

            var $row = $('#edit-' + id);
            var $original = $('#post-' + id);

            // Get featured status from the original row
            var featured = $original.find('._featured_status').text();

            if (featured === '1') {
                $row.find('input[name="menu_featured_quick"]').prop('checked', true);
            }
        };
    })(jQuery);
    </script>
    <?php
}
add_action('admin_footer-edit.php', 'coffeeshop_menu_item_quick_edit_javascript');

/**
 * Save Quick Edit for Menu Items
 */
function coffeeshop_save_menu_item_quick_edit($post_id) {
    if (!isset($_POST['_menu_featured_nonce'])) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $post = get_post($post_id);
    if ($post->post_type !== 'menu_item') {
        return;
    }

    $featured = isset($_POST['menu_featured_quick']) ? '1' : '0';
    update_post_meta($post_id, 'featured_menu_item', $featured);
}
add_action('save_post_menu_item', 'coffeeshop_save_menu_item_quick_edit');

/**
 * Add Featured Column to Menu Items List
 */
function coffeeshop_menu_item_columns($columns) {
    $columns['featured_status'] = __('Featured', 'coffeeshop');
    return $columns;
}
add_filter('manage_menu_item_posts_columns', 'coffeeshop_menu_item_columns');

/**
 * Display Featured Status in Column
 */
function coffeeshop_menu_item_column_content($column, $post_id) {
    if ($column === 'featured_status') {
        $featured = get_post_meta($post_id, 'featured_menu_item', true);
        ?>
        <span class="_featured_status" style="display:none;"><?php echo $featured ? '1' : '0'; ?></span>
        <?php
        if ($featured) {
            echo '<mark class="yes"><span style="color: #2c3338;">Yes</span></mark>';
        } else {
            echo '<span aria-hidden="true">—</span>';
        }
    }
}
add_action('manage_menu_item_posts_custom_column', 'coffeeshop_menu_item_column_content', 10, 2);

/**
 * Add Location Meta Box
 */
function coffeeshop_add_location_meta_box() {
    add_meta_box(
        'location_details',
        __('Location Details', 'coffeeshop'),
        'coffeeshop_location_meta_box_html',
        'cafe_location',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_location_meta_box');

/**
 * Location Meta Box HTML
 */
function coffeeshop_location_meta_box_html($post) {
    wp_nonce_field('coffeeshop_location_meta_box', 'coffeeshop_location_meta_box_nonce');

    $street = get_post_meta($post->ID, 'address_street', true);
    $city = get_post_meta($post->ID, 'address_city', true);
    $state = get_post_meta($post->ID, 'address_state', true);
    $zip = get_post_meta($post->ID, 'address_zip', true);
    $phone = get_post_meta($post->ID, 'phone', true);
    $email = get_post_meta($post->ID, 'email', true);
    $hours = get_post_meta($post->ID, 'hours', true);
    $lat = get_post_meta($post->ID, 'latitude', true);
    $lng = get_post_meta($post->ID, 'longitude', true);
    ?>
    <div style="padding: 10px;">
        <h4><?php _e('Address', 'coffeeshop'); ?></h4>
        <p>
            <label for="location_street" style="display: block; margin-bottom: 5px;"><strong><?php _e('Street Address', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_street" name="location_street" value="<?php echo esc_attr($street); ?>" class="regular-text" />
        </p>

        <p>
            <label for="location_city" style="display: block; margin-bottom: 5px;"><strong><?php _e('City', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_city" name="location_city" value="<?php echo esc_attr($city); ?>" class="regular-text" />
        </p>

        <p>
            <label for="location_state" style="display: block; margin-bottom: 5px;"><strong><?php _e('State', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_state" name="location_state" value="<?php echo esc_attr($state); ?>" class="regular-text" />
        </p>

        <p>
            <label for="location_zip" style="display: block; margin-bottom: 5px;"><strong><?php _e('ZIP Code', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_zip" name="location_zip" value="<?php echo esc_attr($zip); ?>" class="regular-text" />
        </p>

        <h4><?php _e('Contact Information', 'coffeeshop'); ?></h4>
        <p>
            <label for="location_phone" style="display: block; margin-bottom: 5px;"><strong><?php _e('Phone', 'coffeeshop'); ?></strong></label>
            <input type="tel" id="location_phone" name="location_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" />
        </p>

        <p>
            <label for="location_email" style="display: block; margin-bottom: 5px;"><strong><?php _e('Email', 'coffeeshop'); ?></strong></label>
            <input type="email" id="location_email" name="location_email" value="<?php echo esc_attr($email); ?>" class="regular-text" />
        </p>

        <p>
            <label for="location_hours" style="display: block; margin-bottom: 5px;"><strong><?php _e('Hours', 'coffeeshop'); ?></strong></label>
            <textarea id="location_hours" name="location_hours" rows="4" class="large-text" style="width: 100%;" placeholder="Mon-Fri: 7am-7pm&#10;Sat-Sun: 8am-6pm"><?php echo esc_textarea($hours); ?></textarea>
        </p>

        <h4><?php _e('Map Coordinates', 'coffeeshop'); ?></h4>
        <p>
            <label for="location_latitude" style="display: block; margin-bottom: 5px;"><strong><?php _e('Latitude', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_latitude" name="location_latitude" value="<?php echo esc_attr($lat); ?>" class="regular-text" placeholder="e.g., 40.7128" />
        </p>

        <p>
            <label for="location_longitude" style="display: block; margin-bottom: 5px;"><strong><?php _e('Longitude', 'coffeeshop'); ?></strong></label>
            <input type="text" id="location_longitude" name="location_longitude" value="<?php echo esc_attr($lng); ?>" class="regular-text" placeholder="e.g., -74.0060" />
        </p>
    </div>
    <?php
}

/**
 * Save Location Meta Box Data
 */
function coffeeshop_save_location_meta_box($post_id) {
    if (!isset($_POST['coffeeshop_location_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['coffeeshop_location_meta_box_nonce'], 'coffeeshop_location_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['location_street'])) {
        update_post_meta($post_id, 'address_street', sanitize_text_field($_POST['location_street']));
    }
    if (isset($_POST['location_city'])) {
        update_post_meta($post_id, 'address_city', sanitize_text_field($_POST['location_city']));
    }
    if (isset($_POST['location_state'])) {
        update_post_meta($post_id, 'address_state', sanitize_text_field($_POST['location_state']));
    }
    if (isset($_POST['location_zip'])) {
        update_post_meta($post_id, 'address_zip', sanitize_text_field($_POST['location_zip']));
    }
    if (isset($_POST['location_phone'])) {
        update_post_meta($post_id, 'phone', sanitize_text_field($_POST['location_phone']));
    }
    if (isset($_POST['location_email'])) {
        update_post_meta($post_id, 'email', sanitize_email($_POST['location_email']));
    }
    if (isset($_POST['location_hours'])) {
        update_post_meta($post_id, 'hours', sanitize_textarea_field($_POST['location_hours']));
    }
    if (isset($_POST['location_latitude'])) {
        update_post_meta($post_id, 'latitude', sanitize_text_field($_POST['location_latitude']));
    }
    if (isset($_POST['location_longitude'])) {
        update_post_meta($post_id, 'longitude', sanitize_text_field($_POST['location_longitude']));
    }
}
add_action('save_post_cafe_location', 'coffeeshop_save_location_meta_box');

/**
 * Add Team Member Meta Box
 */
function coffeeshop_add_team_member_meta_box() {
    add_meta_box(
        'team_member_details',
        __('Team Member Details', 'coffeeshop'),
        'coffeeshop_team_member_meta_box_html',
        'team_member',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'coffeeshop_add_team_member_meta_box');

/**
 * Team Member Meta Box HTML
 */
function coffeeshop_team_member_meta_box_html($post) {
    wp_nonce_field('coffeeshop_team_member_meta_box', 'coffeeshop_team_member_meta_box_nonce');

    $position = get_post_meta($post->ID, 'position', true);
    $bio = get_post_meta($post->ID, 'bio', true);
    $email = get_post_meta($post->ID, 'email', true);
    $instagram = get_post_meta($post->ID, 'instagram', true);
    $twitter = get_post_meta($post->ID, 'twitter', true);
    $linkedin = get_post_meta($post->ID, 'linkedin', true);
    ?>
    <div style="padding: 10px;">
        <p>
            <label for="team_position" style="display: block; margin-bottom: 5px;"><strong><?php _e('Position', 'coffeeshop'); ?></strong></label>
            <input type="text" id="team_position" name="team_position" value="<?php echo esc_attr($position); ?>" class="regular-text" placeholder="e.g., Head Barista, Manager" />
        </p>

        <p>
            <label for="team_bio" style="display: block; margin-bottom: 5px;"><strong><?php _e('Bio', 'coffeeshop'); ?></strong></label>
            <textarea id="team_bio" name="team_bio" rows="5" class="large-text" style="width: 100%;"><?php echo esc_textarea($bio); ?></textarea>
        </p>

        <h4><?php _e('Contact', 'coffeeshop'); ?></h4>
        <p>
            <label for="team_email" style="display: block; margin-bottom: 5px;"><strong><?php _e('Email', 'coffeeshop'); ?></strong></label>
            <input type="email" id="team_email" name="team_email" value="<?php echo esc_attr($email); ?>" class="regular-text" placeholder="name@example.com" />
        </p>

        <h4><?php _e('Social Links', 'coffeeshop'); ?></h4>
        <p>
            <label for="team_instagram" style="display: block; margin-bottom: 5px;"><strong><?php _e('Instagram', 'coffeeshop'); ?></strong></label>
            <input type="text" id="team_instagram" name="team_instagram" value="<?php echo esc_attr($instagram); ?>" class="regular-text" placeholder="@username" />
        </p>

        <p>
            <label for="team_twitter" style="display: block; margin-bottom: 5px;"><strong><?php _e('Twitter', 'coffeeshop'); ?></strong></label>
            <input type="text" id="team_twitter" name="team_twitter" value="<?php echo esc_attr($twitter); ?>" class="regular-text" placeholder="@username" />
        </p>

        <p>
            <label for="team_linkedin" style="display: block; margin-bottom: 5px;"><strong><?php _e('LinkedIn', 'coffeeshop'); ?></strong></label>
            <input type="text" id="team_linkedin" name="team_linkedin" value="<?php echo esc_attr($linkedin); ?>" class="regular-text" placeholder="https://linkedin.com/in/username" />
        </p>
    </div>
    <?php
}

/**
 * Save Team Member Meta Box Data
 */
function coffeeshop_save_team_member_meta_box($post_id) {
    if (!isset($_POST['coffeeshop_team_member_meta_box_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['coffeeshop_team_member_meta_box_nonce'], 'coffeeshop_team_member_meta_box')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['team_position'])) {
        update_post_meta($post_id, 'position', sanitize_text_field($_POST['team_position']));
    }
    if (isset($_POST['team_bio'])) {
        update_post_meta($post_id, 'bio', sanitize_textarea_field($_POST['team_bio']));
    }
    if (isset($_POST['team_email'])) {
        update_post_meta($post_id, 'email', sanitize_email($_POST['team_email']));
    }
    if (isset($_POST['team_instagram'])) {
        update_post_meta($post_id, 'instagram', sanitize_text_field($_POST['team_instagram']));
    }
    if (isset($_POST['team_twitter'])) {
        update_post_meta($post_id, 'twitter', sanitize_text_field($_POST['team_twitter']));
    }
    if (isset($_POST['team_linkedin'])) {
        update_post_meta($post_id, 'linkedin', esc_url_raw($_POST['team_linkedin']));
    }
}
add_action('save_post_team_member', 'coffeeshop_save_team_member_meta_box');

/**
 * Remove Gutenberg Editor for Coffee Shop CPTs
 */
function coffeeshop_remove_gutenberg_editor($use_block_editor, $post_type) {
    // Disable Gutenberg for all coffee shop CPTs
    if (in_array($post_type, array('coffee_product', 'menu_item', 'cafe_location', 'team_member'))) {
        return false;
    }
    return $use_block_editor;
}
add_filter('use_block_editor_for_post_type', 'coffeeshop_remove_gutenberg_editor', 10, 2);
