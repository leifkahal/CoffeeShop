# Quick Fix Guide

Common issues and their quick solutions.

## Products Page Not Showing Details (Price, Roast Level, Origin)

**Problem**: Products page displays only titles, no metadata.

**Quick Check**:
```bash
curl http://192.168.0.118:10023/wp-json/coffee-shop/v1/products
```

If you get `404`, the endpoint is missing. If you get data but no `meta` field, the endpoint exists but is broken.

**Fix**:

1. **Verify file exists**: `themes/CoffeeShop/inc/rest-api.php`
2. **Verify it's included** in `themes/CoffeeShop/functions.php`:
   ```php
   require_once get_template_directory() . '/inc/rest-api.php';
   ```
3. **Verify endpoint is registered** (look for this in rest-api.php around line 25):
   ```php
   register_rest_route('coffee-shop/v1', '/products', array(
       'methods'  => 'GET',
       'callback' => 'coffeeshop_get_all_products',
       'permission_callback' => '__return_true',
   ));
   ```
4. **Verify callback function exists** (around line 89):
   ```php
   function coffeeshop_get_all_products() { ... }
   ```

If all above exist and it's still broken, check WordPress error logs at `/wp-content/debug.log`.

## Featured Products Work but All Products Don't

This is the symptom of missing `/coffee-shop/v1/products` endpoint.

Both use the `ProductCard` component, so it's definitely an API issue.

**Solution**: Follow "Products Page Not Showing Details" above.

## Locations Page Not Showing Details (Address, Phone, Email, Hours)

**Problem**: Locations page displays only titles, no contact info.

**Quick Check**:
```bash
curl http://192.168.0.118:10023/wp-json/coffee-shop/v1/locations
```

If you get `404`, the endpoint is missing.

**Fix**: Same as products - verify `themes/CoffeeShop/inc/rest-api.php` has:
1. Endpoint registration for `/locations` (around line 44)
2. Callback function `coffeeshop_get_all_locations()` (around line 157)

## Frontend Can't Connect to WordPress

**Check**:
1. `.env.local` has correct URL: `NEXT_PUBLIC_WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json`
2. WordPress is running: `curl http://192.168.0.118:10023/wp-json/`
3. Network can reach the server from your machine
4. No firewall blocking port 10023

## Images Not Loading

**Check**:
1. `next.config.js` has the WordPress domain in `remotePatterns`:
   ```javascript
   {
     protocol: 'http',
     hostname: '192.168.0.118',
     port: '10023',
   }
   ```
2. Featured images in WordPress admin show correct URLs
3. Restart Next.js dev server after updating `next.config.js`

## ISR Not Updating

Products are stuck at old data.

**Check**:
1. ISR revalidation is set to 60 seconds in `src/lib/wordpress.ts` (line 18)
2. Try: `npm run build && npm start` to force rebuild
3. Check server logs for fetch errors

## Database Structure

Coffee products should have these custom meta fields:

| Meta Key | Type | Example |
|----------|------|---------|
| `price` | float | 18.99 |
| `sku` | string | ETH-YRG-001 |
| `roast_level` | string | light / medium / dark |
| `origin` | string | Ethiopia |
| `tasting_notes` | string | Floral, citrus, black tea |
| `stock_status` | string | in-stock / out-of-stock |
| `featured_product` | boolean/string | 1 or true |

If a product shows but with "$0.00" price, the meta field is probably missing or empty.

## Clean Rebuild

If something is weird:

```bash
# Frontend
cd coffee-shop-frontend
rm -rf .next
npm run build
npm start

# WordPress cache (if available)
# Clear any caching plugins in WordPress admin
```

## Files to Check

In order of importance:

1. `themes/CoffeeShop/inc/rest-api.php` - Contains all endpoint definitions
2. `themes/CoffeeShop/functions.php` - Must include rest-api.php
3. `coffee-shop-frontend/src/lib/wordpress.ts` - Frontend API client
4. `coffee-shop-frontend/.env.local` - API URL configuration
5. `coffee-shop-frontend/next.config.js` - Image domain whitelist

## Contact Points

- **WordPress Backend**: `themes/CoffeeShop/` folder
- **Frontend**: `coffee-shop-frontend/src/` folder
- **API**: `themes/CoffeeShop/inc/rest-api.php`
- **Troubleshooting Docs**: `REST_API_GUIDE.md` and `DEPLOYMENT.md`
