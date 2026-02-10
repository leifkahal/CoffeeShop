# Changelog

All notable changes to the CoffeeShop Frontend are documented here.

## [1.0.1] - Feb 9, 2025

### Fixed

#### Missing REST API Endpoints
Two critical custom REST API endpoints were missing, causing data to not display on their respective pages:

1. **Products Page** - `/coffee-shop/v1/products`
   - **Issue**: Products page displayed only titles; no price, roast level, or origin info
   - **Root Cause**: Standard WordPress REST API endpoint (`/wp/v2/coffee_product`) does not include custom meta fields
   - **Solution**: Created custom endpoint that returns ALL products with complete metadata
   - **Files Modified**:
     - `themes/CoffeeShop/inc/rest-api.php`: Added endpoint registration and `coffeeshop_get_all_products()` callback
     - `src/lib/wordpress.ts`: Updated `getProducts()` to use custom endpoint

2. **Locations Page** - `/coffee-shop/v1/locations`
   - **Issue**: Locations page displayed only titles; no address, phone, email, or hours
   - **Root Cause**: Standard WordPress REST API endpoint (`/wp/v2/cafe_location`) does not include custom meta fields
   - **Solution**: Created custom endpoint that returns ALL locations with complete metadata
   - **Files Modified**:
     - `themes/CoffeeShop/inc/rest-api.php`: Added endpoint registration and `coffeeshop_get_all_locations()` callback
     - `src/lib/wordpress.ts`: Updated `getLocations()` to use custom endpoint

### Added

#### Documentation
- `REST_API_GUIDE.md`: Comprehensive reference for all REST API endpoints with examples
- `QUICK_FIX_GUIDE.md`: Quick troubleshooting guide for common issues
- Updated `README.md` with API endpoints table and troubleshooting section
- Enhanced `rest-api.php` with critical header comments

### Important Notes

- **Critical File**: `themes/CoffeeShop/inc/rest-api.php` must be present and properly included
- Both custom endpoints return complete metadata including images
- All meta fields are properly typed (strings, floats, booleans)
- Standard WordPress REST API endpoints are inadequate for this use case

## How to Verify the Fix

```bash
# Test products endpoint
curl http://192.168.0.118:10023/wp-json/coffee-shop/v1/products

# Test locations endpoint  
curl http://192.168.0.118:10023/wp-json/coffee-shop/v1/locations
```

Both should return arrays with complete metadata for all items.

## Prevention for Future

If similar issues occur:
1. Check that `themes/CoffeeShop/inc/rest-api.php` exists and is not corrupted
2. Verify it's included in `themes/CoffeeShop/functions.php`
3. Test endpoints with curl commands
4. Check WordPress debug log for PHP errors
5. Refer to `REST_API_GUIDE.md` for endpoint specifications
