<?php
/**
 * Headless WordPress Theme - CoffeeShop
 *
 * This theme is designed to work with a separate Next.js frontend application.
 * All content is accessed via the WordPress REST API.
 *
 * @package CoffeeShop
 */

if (!defined('ABSPATH')) {
    exit;
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo('name'); ?> - Headless WordPress</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 800px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }
        h1::before {
            content: '☕ ';
        }
        p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        h2 {
            font-size: 1.8rem;
            color: #444;
            margin-top: 40px;
            margin-bottom: 20px;
        }
        ul {
            list-style: none;
            margin-bottom: 30px;
        }
        li {
            margin-bottom: 12px;
            padding-left: 25px;
            position: relative;
        }
        li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: #667eea;
            font-weight: bold;
        }
        a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        .badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .info-box {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .endpoint-list {
            background: #f7fafc;
            padding: 20px;
            border-radius: 10px;
            margin-top: 10px;
        }
        code {
            background: #e2e8f0;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Headless WordPress Active</h1>

        <p>This WordPress installation is running in <strong>headless mode</strong> as a content management system.</p>

        <div class="info-box">
            <p><strong>Frontend Application:</strong> <a href="http://localhost:3000" target="_blank">http://localhost:3000</a></p>
            <p><strong>REST API Base:</strong> <a href="<?php echo esc_url(rest_url()); ?>" target="_blank"><?php echo esc_url(rest_url()); ?></a></p>
        </div>

        <h2>Custom Post Types</h2>
        <div>
            <span class="badge">Products</span>
            <span class="badge">Menu Items</span>
            <span class="badge">Locations</span>
            <span class="badge">Team Members</span>
        </div>

        <h2>Available API Endpoints</h2>
        <div class="endpoint-list">
            <ul>
                <li>
                    <strong>Products:</strong><br>
                    <code><a href="<?php echo esc_url(rest_url('wp/v2/coffee_product')); ?>" target="_blank"><?php echo esc_url(rest_url('wp/v2/coffee_product')); ?></a></code>
                </li>
                <li>
                    <strong>Menu Items:</strong><br>
                    <code><a href="<?php echo esc_url(rest_url('wp/v2/menu_item')); ?>" target="_blank"><?php echo esc_url(rest_url('wp/v2/menu_item')); ?></a></code>
                </li>
                <li>
                    <strong>Locations:</strong><br>
                    <code><a href="<?php echo esc_url(rest_url('wp/v2/cafe_location')); ?>" target="_blank"><?php echo esc_url(rest_url('wp/v2/cafe_location')); ?></a></code>
                </li>
                <li>
                    <strong>Team Members:</strong><br>
                    <code><a href="<?php echo esc_url(rest_url('wp/v2/team_member')); ?>" target="_blank"><?php echo esc_url(rest_url('wp/v2/team_member')); ?></a></code>
                </li>
                <li>
                    <strong>Custom Menu Endpoint:</strong><br>
                    <code><a href="<?php echo esc_url(rest_url('coffee-shop/v1/menu')); ?>" target="_blank"><?php echo esc_url(rest_url('coffee-shop/v1/menu')); ?></a></code>
                </li>
            </ul>
        </div>

        <h2>Content Management</h2>
        <p>To manage content, please visit the <a href="<?php echo esc_url(admin_url()); ?>">WordPress Admin Dashboard</a>.</p>

        <p style="margin-top: 40px; font-size: 0.9rem; color: #999;">
            CoffeeShop Headless Theme v1.0.0 | Powered by WordPress <?php bloginfo('version'); ?>
        </p>
    </div>
</body>
</html>
