# REST API Guide

This guide documents the custom WordPress REST API endpoints used by the CoffeeShop frontend.

## Overview

All custom endpoints are defined in the CoffeeShop WordPress theme:
- **File**: `themes/CoffeeShop/inc/rest-api.php`
- **Namespace**: `coffee-shop/v1`
- **Base URL**: `{wordpress-domain}/wp-json/coffee-shop/v1`

## Endpoints

### 1. Get All Products

**Endpoint**: `GET /coffee-shop/v1/products`

**Purpose**: Retrieve all published coffee products with complete metadata.

**Response**:
```json
[
  {
    "id": 7,
    "slug": "ethiopian-yirgacheffe",
    "title": { "rendered": "Ethiopian Yirgacheffe" },
    "content": { "rendered": "Description..." },
    "excerpt": { "rendered": "" },
    "featured_image_url": {
      "thumbnail": "...",
      "medium": "...",
      "large": "...",
      "full": "..."
    },
    "meta": {
      "price": 18.99,
      "sku": "ETH-YRG-001",
      "roast_level": "light",
      "origin": "Ethiopia",
      "tasting_notes": "Floral, citrus, black tea, honey",
      "stock_status": "in-stock",
      "featured_product": true
    }
  }
]
```

**Frontend Usage**:
```typescript
// src/lib/wordpress.ts
export async function getProducts(): Promise<Product[]> {
  return await fetchAPI('/coffee-shop/v1/products')
}

// src/app/products/page.tsx
const products = await getProducts()
products.map(product => <ProductCard {...product} />)
```

### 2. Get Featured Products

**Endpoint**: `GET /coffee-shop/v1/products/featured`

**Purpose**: Retrieve only products marked as featured (meta.featured_product = true).

**Response**: Same structure as `/products` endpoint, but filtered.

**Frontend Usage**:
```typescript
export async function getFeaturedProducts(): Promise<Product[]> {
  return await fetchAPI('/coffee-shop/v1/products/featured')
}

// Used on homepage
const featured = await getFeaturedProducts()
```

### 3. Get All Locations

**Endpoint**: `GET /coffee-shop/v1/locations`

**Purpose**: Retrieve all published café locations with complete address and contact information.

**Response**:
```json
[
  {
    "id": 27,
    "slug": "downtown-location",
    "title": { "rendered": "Downtown Location" },
    "content": { "rendered": "Our flagship location..." },
    "excerpt": { "rendered": "" },
    "featured_image_url": { "thumbnail": false, "medium": false, "large": false, "full": false },
    "meta": {
      "address_street": "123 Main Street",
      "address_city": "Seattle",
      "address_state": "WA",
      "address_zip": "98101",
      "phone": "(206) 555-0100",
      "email": "downtown@coffeeshop.com",
      "hours": "Monday - Friday: 6:00 AM - 8:00 PM\nSaturday - Sunday: 7:00 AM - 9:00 PM",
      "latitude": "47.6062",
      "longitude": "-122.3321"
    }
  }
]
```

**Frontend Usage**:
```typescript
export async function getLocations(): Promise<Location[]> {
  return await fetchAPI('/coffee-shop/v1/locations')
}

// Used on locations page
const locations = await getLocations()
locations.map(location => <LocationCard {...location} />)
```

### 5. Get Menu by Category

**Endpoint**: `GET /coffee-shop/v1/menu`

**Purpose**: Retrieve menu items grouped by category (hot, cold, food).

**Response**:
```json
{
  "hot": [
    {
      "id": 1,
      "title": { "rendered": "Espresso" },
      "meta": {
        "price": 3.50,
        "category": "hot",
        "ingredients": "espresso",
        "allergens": "none",
        "availability": "available"
      }
    }
  ],
  "cold": [],
  "food": []
}
```

### 6. Get Nearest Location

**Endpoint**: `GET /coffee-shop/v1/locations/nearest`

**Purpose**: Retrieve the nearest café location (placeholder for future geolocation).

**Response**:
```json
{
  "id": 1,
  "title": "Main Location",
  "slug": "main-location",
  "description": "...",
  "address": {
    "street": "123 Main St",
    "city": "City",
    "state": "ST",
    "zip": "12345"
  },
  "phone": "555-1234",
  "email": "location@coffeeshop.com",
  "hours": "6am - 8pm",
  "coordinates": {
    "latitude": "0.0",
    "longitude": "0.0"
  }
}
```

## Implementation Details

### Endpoint Registration

Located in `themes/CoffeeShop/inc/rest-api.php`, function `coffeeshop_register_rest_routes()`:

```php
register_rest_route('coffee-shop/v1', '/products', array(
    'methods'  => 'GET',
    'callback' => 'coffeeshop_get_all_products',
    'permission_callback' => '__return_true',
));
```

### Callback Functions

Each endpoint has a corresponding callback function that:
1. Sets up query arguments (`WP_Query`)
2. Fetches posts from the database
3. Builds the response array with all necessary fields
4. Returns via `rest_ensure_response()`

**Important**: All callback functions manually construct the response array. The endpoints do NOT use the standard REST API, so we have full control over what data is included.

## Troubleshooting

### Endpoint Returns 404

**Check**:
1. Is `themes/CoffeeShop/inc/rest-api.php` file present?
2. Is the file included in `themes/CoffeeShop/functions.php`?
3. Are the `register_rest_route()` calls in the function `coffeeshop_register_rest_routes()`?
4. Is `add_action('rest_api_init', 'coffeeshop_register_rest_routes')` present?

### Missing Metadata in Response

**Check**:
1. The callback function should include all meta fields via `get_post_meta()`
2. Verify the meta keys are correct in the database:
   - `price` (float)
   - `roast_level` (string: light/medium/dark)
   - `origin` (string: country name)
   - `tasting_notes` (string)
   - etc.

### Frontend Not Displaying Product Details

1. Check that `getProducts()` is calling the correct endpoint
2. Verify the API response includes all required fields
3. Test: `curl http://wordpress-domain/wp-json/coffee-shop/v1/products`
4. Check browser console for network errors
5. Check server logs for PHP errors

## Adding New Endpoints

To add a new endpoint:

1. Add the route registration in `coffeeshop_register_rest_routes()`:
   ```php
   register_rest_route('coffee-shop/v1', '/your-endpoint', array(
       'methods'  => 'GET',
       'callback' => 'coffeeshop_get_your_endpoint',
       'permission_callback' => '__return_true',
   ));
   ```

2. Create the callback function:
   ```php
   function coffeeshop_get_your_endpoint() {
       // Your logic here
       return rest_ensure_response($data);
   }
   ```

3. Add the corresponding function in the frontend (`src/lib/wordpress.ts`):
   ```typescript
   export async function getYourEndpoint() {
       return await fetchAPI('/coffee-shop/v1/your-endpoint')
   }
   ```

## Performance Notes

- All endpoints use ISR (Incremental Static Regeneration) with 60-second revalidation
- No pagination is implemented (fetches all posts with `posts_per_page: -1`)
- Consider adding pagination for large datasets
- All meta fields are fetched via individual `get_post_meta()` calls - consider caching if performance becomes an issue

## Version History

**Feb 9, 2025**:
- Created `/coffee-shop/v1/products` endpoint (was missing, causing products page to not display metadata)
- Created `/coffee-shop/v1/locations` endpoint (was missing, causing locations page to not display address/contact info)
- Documented all endpoints and troubleshooting steps
