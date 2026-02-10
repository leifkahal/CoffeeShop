<?php
/**
 * Sample Data Generator
 *
 * Provides an admin page to generate sample data for testing.
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu page
 */
function coffeeshop_add_sample_data_menu() {
    add_menu_page(
        __('Sample Data', 'coffeeshop'),
        __('Sample Data', 'coffeeshop'),
        'manage_options',
        'coffeeshop-sample-data',
        'coffeeshop_sample_data_page',
        'dashicons-database-add',
        30
    );
}
add_action('admin_menu', 'coffeeshop_add_sample_data_menu');

/**
 * Handle sample data generation
 */
function coffeeshop_handle_sample_data_generation() {
    if (!isset($_POST['coffeeshop_generate_sample_data_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['coffeeshop_generate_sample_data_nonce'], 'coffeeshop_generate_sample_data')) {
        wp_die(__('Security check failed', 'coffeeshop'));
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to access this page.', 'coffeeshop'));
    }

    // Generate sample data
    $products_created = coffeeshop_generate_sample_products();
    $menu_items_created = coffeeshop_generate_sample_menu_items();
    $locations_created = coffeeshop_generate_sample_locations();
    $team_members_created = coffeeshop_generate_sample_team_members();

    // Set success message
    $message = sprintf(
        __('Sample data created successfully! Created %d products, %d menu items, %d locations, and %d team members.', 'coffeeshop'),
        $products_created,
        $menu_items_created,
        $locations_created,
        $team_members_created
    );

    set_transient('coffeeshop_sample_data_notice', $message, 30);

    wp_redirect(admin_url('admin.php?page=coffeeshop-sample-data'));
    exit;
}
add_action('admin_post_coffeeshop_generate_sample_data', 'coffeeshop_handle_sample_data_generation');

/**
 * Handle sample data deletion
 */
function coffeeshop_handle_sample_data_deletion() {
    if (!isset($_POST['coffeeshop_delete_sample_data_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['coffeeshop_delete_sample_data_nonce'], 'coffeeshop_delete_sample_data')) {
        wp_die(__('Security check failed', 'coffeeshop'));
    }

    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to access this page.', 'coffeeshop'));
    }

    // Delete all custom post types
    $deleted = 0;
    $post_types = array('coffee_product', 'menu_item', 'cafe_location', 'team_member');

    foreach ($post_types as $post_type) {
        $posts = get_posts(array(
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'any',
        ));

        foreach ($posts as $post) {
            wp_delete_post($post->ID, true);
            $deleted++;
        }
    }

    $message = sprintf(__('Deleted %d items successfully.', 'coffeeshop'), $deleted);
    set_transient('coffeeshop_sample_data_notice', $message, 30);

    wp_redirect(admin_url('admin.php?page=coffeeshop-sample-data'));
    exit;
}
add_action('admin_post_coffeeshop_delete_sample_data', 'coffeeshop_handle_sample_data_deletion');

/**
 * Sample data admin page
 */
function coffeeshop_sample_data_page() {
    // Show success message if available
    if ($message = get_transient('coffeeshop_sample_data_notice')) {
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html($message) . '</p></div>';
        delete_transient('coffeeshop_sample_data_notice');
    }

    // Get counts
    $products_count = wp_count_posts('coffee_product')->publish;
    $menu_items_count = wp_count_posts('menu_item')->publish;
    $locations_count = wp_count_posts('cafe_location')->publish;
    $team_members_count = wp_count_posts('team_member')->publish;
    ?>
    <div class="wrap">
        <h1>☕ <?php _e('Sample Data Generator', 'coffeeshop'); ?></h1>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Current Content', 'coffeeshop'); ?></h2>
            <table class="widefat" style="margin-top: 10px;">
                <thead>
                    <tr>
                        <th><?php _e('Content Type', 'coffeeshop'); ?></th>
                        <th><?php _e('Count', 'coffeeshop'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php _e('Products', 'coffeeshop'); ?></td>
                        <td><strong><?php echo esc_html($products_count); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php _e('Menu Items', 'coffeeshop'); ?></td>
                        <td><strong><?php echo esc_html($menu_items_count); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php _e('Locations', 'coffeeshop'); ?></td>
                        <td><strong><?php echo esc_html($locations_count); ?></strong></td>
                    </tr>
                    <tr>
                        <td><?php _e('Team Members', 'coffeeshop'); ?></td>
                        <td><strong><?php echo esc_html($team_members_count); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Generate Sample Data', 'coffeeshop'); ?></h2>
            <p><?php _e('Click the button below to generate sample data for testing your coffee shop website.', 'coffeeshop'); ?></p>

            <h3><?php _e('This will create:', 'coffeeshop'); ?></h3>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><strong>8 Products</strong> - Various coffee beans and merchandise</li>
                <li><strong>12 Menu Items</strong> - Hot drinks, cold drinks, and food</li>
                <li><strong>3 Locations</strong> - Different cafe locations</li>
                <li><strong>5 Team Members</strong> - Staff profiles</li>
            </ul>

            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="margin-top: 20px;">
                <?php wp_nonce_field('coffeeshop_generate_sample_data', 'coffeeshop_generate_sample_data_nonce'); ?>
                <input type="hidden" name="action" value="coffeeshop_generate_sample_data">
                <button type="submit" class="button button-primary button-hero" style="margin-bottom: 10px;">
                    <?php _e('🎲 Generate Sample Data', 'coffeeshop'); ?>
                </button>
                <p class="description">
                    <?php _e('Note: This will create new posts. Existing content will not be affected.', 'coffeeshop'); ?>
                </p>
            </form>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px; border-left: 4px solid #dc3232;">
            <h2><?php _e('Delete All Content', 'coffeeshop'); ?></h2>
            <p><?php _e('Use this to delete all products, menu items, locations, and team members.', 'coffeeshop'); ?></p>

            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" onsubmit="return confirm('Are you sure you want to delete ALL content? This cannot be undone!');">
                <?php wp_nonce_field('coffeeshop_delete_sample_data', 'coffeeshop_delete_sample_data_nonce'); ?>
                <input type="hidden" name="action" value="coffeeshop_delete_sample_data">
                <button type="submit" class="button button-secondary">
                    <?php _e('🗑️ Delete All Content', 'coffeeshop'); ?>
                </button>
            </form>
        </div>

        <div class="card" style="max-width: 800px; margin-top: 20px;">
            <h2><?php _e('Quick Links', 'coffeeshop'); ?></h2>
            <p>
                <a href="<?php echo admin_url('edit.php?post_type=coffee_product'); ?>" class="button"><?php _e('View Products', 'coffeeshop'); ?></a>
                <a href="<?php echo admin_url('edit.php?post_type=menu_item'); ?>" class="button"><?php _e('View Menu Items', 'coffeeshop'); ?></a>
                <a href="<?php echo admin_url('edit.php?post_type=cafe_location'); ?>" class="button"><?php _e('View Locations', 'coffeeshop'); ?></a>
                <a href="<?php echo admin_url('edit.php?post_type=team_member'); ?>" class="button"><?php _e('View Team', 'coffeeshop'); ?></a>
            </p>
            <p>
                <a href="<?php echo rest_url('wp/v2/coffee_product'); ?>" class="button" target="_blank"><?php _e('🔗 View Products API', 'coffeeshop'); ?></a>
                <a href="<?php echo rest_url('coffee-shop/v1/menu'); ?>" class="button" target="_blank"><?php _e('🔗 View Menu API', 'coffeeshop'); ?></a>
            </p>
        </div>
    </div>
    <?php
}

/**
 * Generate sample products
 */
function coffeeshop_generate_sample_products() {
    $products = array(
        array(
            'title' => 'Ethiopian Yirgacheffe',
            'content' => 'A delicate, tea-like coffee with floral notes and a wine-like acidity. Grown in the birthplace of coffee.',
            'price' => 18.99,
            'sku' => 'ETH-YRG-001',
            'roast_level' => 'light',
            'origin' => 'Ethiopia',
            'tasting_notes' => 'Floral, citrus, black tea, honey',
            'stock_status' => 'in-stock',
            'featured' => true,
        ),
        array(
            'title' => 'Colombian Supremo',
            'content' => 'A balanced, smooth coffee with notes of caramel and nuts. Perfect for everyday drinking.',
            'price' => 15.99,
            'sku' => 'COL-SUP-001',
            'roast_level' => 'medium',
            'origin' => 'Colombia',
            'tasting_notes' => 'Caramel, nuts, chocolate, balanced',
            'stock_status' => 'in-stock',
            'featured' => false,
        ),
        array(
            'title' => 'Sumatra Mandheling',
            'content' => 'A full-bodied, earthy coffee with low acidity. Rich and complex with a syrupy mouthfeel.',
            'price' => 17.99,
            'sku' => 'SUM-MAN-001',
            'roast_level' => 'dark',
            'origin' => 'Indonesia',
            'tasting_notes' => 'Earthy, herbal, dark chocolate, cedar',
            'stock_status' => 'in-stock',
            'featured' => true,
        ),
        array(
            'title' => 'Costa Rican Tarrazu',
            'content' => 'A bright, clean coffee with excellent balance. Known for its full body and rich flavor.',
            'price' => 16.99,
            'sku' => 'CRI-TAR-001',
            'roast_level' => 'medium',
            'origin' => 'Costa Rica',
            'tasting_notes' => 'Citrus, honey, clean, bright',
            'stock_status' => 'in-stock',
            'featured' => false,
        ),
        array(
            'title' => 'Kenya AA',
            'content' => 'A bold, wine-like coffee with intense flavor. One of the most distinctive coffees in the world.',
            'price' => 19.99,
            'sku' => 'KEN-AA-001',
            'roast_level' => 'light',
            'origin' => 'Kenya',
            'tasting_notes' => 'Blackcurrant, wine, tomato, bold',
            'stock_status' => 'in-stock',
            'featured' => true,
        ),
        array(
            'title' => 'Brazil Santos',
            'content' => 'A mild, sweet coffee with low acidity. Perfect for those new to specialty coffee.',
            'price' => 14.99,
            'sku' => 'BRA-SAN-001',
            'roast_level' => 'medium',
            'origin' => 'Brazil',
            'tasting_notes' => 'Sweet, nutty, chocolate, mild',
            'stock_status' => 'in-stock',
            'featured' => false,
        ),
        array(
            'title' => 'House Blend',
            'content' => 'Our signature blend combining beans from three continents for perfect balance.',
            'price' => 13.99,
            'sku' => 'HOUSE-001',
            'roast_level' => 'medium',
            'origin' => 'Blend',
            'tasting_notes' => 'Balanced, smooth, versatile',
            'stock_status' => 'in-stock',
            'featured' => false,
        ),
        array(
            'title' => 'Decaf Colombian',
            'content' => 'All the flavor, none of the caffeine. Swiss water processed for chemical-free decaffeination.',
            'price' => 16.99,
            'sku' => 'DECAF-COL-001',
            'roast_level' => 'medium',
            'origin' => 'Colombia',
            'tasting_notes' => 'Smooth, caramel, chocolate',
            'stock_status' => 'in-stock',
            'featured' => false,
        ),
    );

    $created = 0;
    foreach ($products as $product) {
        $post_id = wp_insert_post(array(
            'post_title' => $product['title'],
            'post_content' => $product['content'],
            'post_status' => 'publish',
            'post_type' => 'coffee_product',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'price', $product['price']);
            update_post_meta($post_id, 'sku', $product['sku']);
            update_post_meta($post_id, 'roast_level', $product['roast_level']);
            update_post_meta($post_id, 'origin', $product['origin']);
            update_post_meta($post_id, 'tasting_notes', $product['tasting_notes']);
            update_post_meta($post_id, 'stock_status', $product['stock_status']);
            update_post_meta($post_id, 'featured_product', $product['featured'] ? '1' : '0');
            $created++;
        }
    }

    return $created;
}

/**
 * Generate sample menu items
 */
function coffeeshop_generate_sample_menu_items() {
    $menu_items = array(
        // Hot drinks
        array(
            'title' => 'Espresso',
            'content' => 'A concentrated shot of pure coffee perfection.',
            'category' => 'hot',
            'price' => 3.50,
            'ingredients' => 'Espresso (single origin)',
            'allergens' => '',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Cappuccino',
            'content' => 'Equal parts espresso, steamed milk, and foam.',
            'category' => 'hot',
            'price' => 4.50,
            'ingredients' => 'Espresso, steamed milk, foam',
            'allergens' => 'Dairy',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Caramel Latte',
            'content' => 'Smooth latte with rich caramel syrup.',
            'category' => 'hot',
            'price' => 5.50,
            'ingredients' => 'Espresso, steamed milk, caramel syrup',
            'allergens' => 'Dairy',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Mocha',
            'content' => 'The perfect blend of coffee and chocolate.',
            'category' => 'hot',
            'price' => 5.50,
            'ingredients' => 'Espresso, steamed milk, chocolate syrup, whipped cream',
            'allergens' => 'Dairy',
            'availability' => 'all-day',
        ),
        // Cold drinks
        array(
            'title' => 'Iced Latte',
            'content' => 'Espresso and cold milk over ice.',
            'category' => 'cold',
            'price' => 5.00,
            'ingredients' => 'Espresso, cold milk, ice',
            'allergens' => 'Dairy',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Cold Brew',
            'content' => 'Smooth, low-acid coffee steeped for 24 hours.',
            'category' => 'cold',
            'price' => 4.50,
            'ingredients' => 'Cold brew concentrate, water, ice',
            'allergens' => '',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Iced Caramel Macchiato',
            'content' => 'Vanilla syrup, milk, espresso, and caramel drizzle.',
            'category' => 'cold',
            'price' => 6.00,
            'ingredients' => 'Vanilla syrup, milk, espresso, caramel, ice',
            'allergens' => 'Dairy',
            'availability' => 'all-day',
        ),
        array(
            'title' => 'Nitro Cold Brew',
            'content' => 'Cold brew infused with nitrogen for a creamy texture.',
            'category' => 'cold',
            'price' => 5.50,
            'ingredients' => 'Cold brew, nitrogen',
            'allergens' => '',
            'availability' => 'all-day',
        ),
        // Food
        array(
            'title' => 'Croissant',
            'content' => 'Buttery, flaky French pastry.',
            'category' => 'food',
            'price' => 3.50,
            'ingredients' => 'Flour, butter, yeast, milk, sugar',
            'allergens' => 'Gluten, Dairy',
            'availability' => 'breakfast',
        ),
        array(
            'title' => 'Blueberry Muffin',
            'content' => 'Freshly baked with plump blueberries.',
            'category' => 'food',
            'price' => 4.00,
            'ingredients' => 'Flour, blueberries, sugar, butter, eggs',
            'allergens' => 'Gluten, Dairy, Eggs',
            'availability' => 'breakfast',
        ),
        array(
            'title' => 'Avocado Toast',
            'content' => 'Smashed avocado on sourdough with everything seasoning.',
            'category' => 'food',
            'price' => 8.50,
            'ingredients' => 'Sourdough bread, avocado, lemon, olive oil, sea salt, everything seasoning',
            'allergens' => 'Gluten',
            'availability' => 'breakfast, lunch',
        ),
        array(
            'title' => 'Chocolate Chip Cookie',
            'content' => 'Classic cookie with premium chocolate chips.',
            'category' => 'food',
            'price' => 3.00,
            'ingredients' => 'Flour, butter, sugar, chocolate chips, eggs',
            'allergens' => 'Gluten, Dairy, Eggs',
            'availability' => 'all-day',
        ),
    );

    $created = 0;
    foreach ($menu_items as $item) {
        $post_id = wp_insert_post(array(
            'post_title' => $item['title'],
            'post_content' => $item['content'],
            'post_status' => 'publish',
            'post_type' => 'menu_item',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'category', $item['category']);
            update_post_meta($post_id, 'price', $item['price']);
            update_post_meta($post_id, 'ingredients', $item['ingredients']);
            update_post_meta($post_id, 'allergens', $item['allergens']);
            update_post_meta($post_id, 'availability', $item['availability']);
            $created++;
        }
    }

    return $created;
}

/**
 * Generate sample locations
 */
function coffeeshop_generate_sample_locations() {
    $locations = array(
        array(
            'title' => 'Downtown Location',
            'content' => 'Our flagship location in the heart of downtown. Features a spacious interior with plenty of seating and free WiFi.',
            'address_street' => '123 Main Street',
            'address_city' => 'Seattle',
            'address_state' => 'WA',
            'address_zip' => '98101',
            'phone' => '(206) 555-0100',
            'email' => 'downtown@coffeeshop.com',
            'hours' => "Monday - Friday: 6:00 AM - 8:00 PM\nSaturday - Sunday: 7:00 AM - 9:00 PM",
            'latitude' => '47.6062',
            'longitude' => '-122.3321',
        ),
        array(
            'title' => 'University District',
            'content' => 'Located near the university campus. Perfect for students and study groups. Free WiFi and plenty of power outlets.',
            'address_street' => '4567 University Way NE',
            'address_city' => 'Seattle',
            'address_state' => 'WA',
            'address_zip' => '98105',
            'phone' => '(206) 555-0200',
            'email' => 'university@coffeeshop.com',
            'hours' => "Monday - Friday: 6:30 AM - 10:00 PM\nSaturday - Sunday: 7:00 AM - 10:00 PM",
            'latitude' => '47.6585',
            'longitude' => '-122.3139',
        ),
        array(
            'title' => 'Capitol Hill',
            'content' => 'Our cozy neighborhood cafe. Great for meeting friends or working remotely. Dog-friendly patio available.',
            'address_street' => '789 Broadway E',
            'address_city' => 'Seattle',
            'address_state' => 'WA',
            'address_zip' => '98102',
            'phone' => '(206) 555-0300',
            'email' => 'capitolhill@coffeeshop.com',
            'hours' => "Monday - Friday: 7:00 AM - 7:00 PM\nSaturday - Sunday: 8:00 AM - 8:00 PM",
            'latitude' => '47.6205',
            'longitude' => '-122.3212',
        ),
    );

    $created = 0;
    foreach ($locations as $location) {
        $post_id = wp_insert_post(array(
            'post_title' => $location['title'],
            'post_content' => $location['content'],
            'post_status' => 'publish',
            'post_type' => 'cafe_location',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'address_street', $location['address_street']);
            update_post_meta($post_id, 'address_city', $location['address_city']);
            update_post_meta($post_id, 'address_state', $location['address_state']);
            update_post_meta($post_id, 'address_zip', $location['address_zip']);
            update_post_meta($post_id, 'phone', $location['phone']);
            update_post_meta($post_id, 'email', $location['email']);
            update_post_meta($post_id, 'hours', $location['hours']);
            update_post_meta($post_id, 'latitude', $location['latitude']);
            update_post_meta($post_id, 'longitude', $location['longitude']);
            $created++;
        }
    }

    return $created;
}

/**
 * Generate sample team members
 */
function coffeeshop_generate_sample_team_members() {
    $team_members = array(
        array(
            'title' => 'Sarah Martinez',
            'content' => 'Sarah discovered her passion for coffee while studying abroad in Italy. She brings 10 years of experience and a dedication to quality.',
            'position' => 'Head Barista',
            'bio' => 'Sarah is our lead barista and coffee expert. She oversees training, quality control, and menu development.',
            'instagram' => '@sarahcoffee',
            'twitter' => '@sarahmartinez',
            'linkedin' => '',
        ),
        array(
            'title' => 'James Chen',
            'content' => 'James manages our operations and ensures every customer has an amazing experience.',
            'position' => 'General Manager',
            'bio' => 'With a background in hospitality management, James keeps our shops running smoothly and our team motivated.',
            'instagram' => '@jameschen',
            'twitter' => '',
            'linkedin' => 'https://linkedin.com/in/jameschen',
        ),
        array(
            'title' => 'Emily Rodriguez',
            'content' => 'Emily is passionate about creating beautiful latte art and experimenting with new drink recipes.',
            'position' => 'Senior Barista',
            'bio' => 'Emily specializes in espresso drinks and latte art. Her creations are almost too beautiful to drink!',
            'instagram' => '@emilylatteartist',
            'twitter' => '@emilyrodriguez',
            'linkedin' => '',
        ),
        array(
            'title' => 'Marcus Thompson',
            'content' => 'Marcus travels the world sourcing the best coffee beans directly from farmers.',
            'position' => 'Coffee Buyer',
            'bio' => 'Marcus builds relationships with coffee farmers and ensures we get the highest quality beans while supporting sustainable practices.',
            'instagram' => '@marcuscoffeebuyer',
            'twitter' => '@marcusthompson',
            'linkedin' => 'https://linkedin.com/in/marcusthompson',
        ),
        array(
            'title' => 'Aisha Patel',
            'content' => 'Aisha is our roast master, carefully roasting each batch to bring out unique flavor profiles.',
            'position' => 'Head Roaster',
            'bio' => 'Aisha oversees all roasting operations and quality control. She has a keen palate and years of experience perfecting roast profiles.',
            'instagram' => '@aisharoasts',
            'twitter' => '@aishapatel',
            'linkedin' => '',
        ),
    );

    $created = 0;
    foreach ($team_members as $member) {
        $post_id = wp_insert_post(array(
            'post_title' => $member['title'],
            'post_content' => $member['content'],
            'post_status' => 'publish',
            'post_type' => 'team_member',
        ));

        if ($post_id) {
            update_post_meta($post_id, 'position', $member['position']);
            update_post_meta($post_id, 'bio', $member['bio']);
            update_post_meta($post_id, 'instagram', $member['instagram']);
            update_post_meta($post_id, 'twitter', $member['twitter']);
            update_post_meta($post_id, 'linkedin', $member['linkedin']);
            $created++;
        }
    }

    return $created;
}
