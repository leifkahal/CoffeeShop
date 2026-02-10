# CoffeeShop Frontend - Next.js

Modern Next.js frontend for the CoffeeShop headless WordPress site.

## Features

- **Next.js 15** with App Router
- **TypeScript** for type safety
- **Tailwind CSS** for styling
- **WordPress REST API** integration
- **Server-side rendering** and ISR
- **Responsive design** for all devices

## Getting Started

### Prerequisites

- Node.js 18+ and npm
- WordPress backend running at `coffee-shop.local`

### Installation

```bash
# Install dependencies
npm install

# Start development server
npm run dev
```

Visit [http://localhost:3000](http://localhost:3000)

## Environment Variables

Create `.env.local`:

```env
NEXT_PUBLIC_WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
```

**⚠️ Important**: The WordPress URL was recently changed from `http://localhost:10003` to `http://192.168.0.118:10023`. If you're deploying or changing environments, update both this file and the `remotePatterns` in `next.config.js`. See [DEPLOYMENT.md](./DEPLOYMENT.md) for detailed configuration instructions.

## Project Structure

```
src/
├── app/                  # App Router pages
│   ├── layout.tsx       # Root layout
│   ├── page.tsx         # Homepage
│   ├── products/        # Products pages
│   ├── menu/            # Menu page
│   ├── locations/       # Locations page
│   └── about/           # About page
├── components/
│   └── layout/          # Layout components
│       ├── Header.tsx
│       └── Footer.tsx
├── lib/
│   └── wordpress.ts     # WordPress API client
└── types/
    └── wordpress.ts     # TypeScript types
```

## Customization

### Colors

Edit `tailwind.config.ts` to customize the color palette:

```typescript
colors: {
  primary: '#2c1810',    // Main brand color
  secondary: '#d4a574',  // Secondary color
  accent: '#8b4513',     // Accent color
  background: '#faf8f3', // Background
}
```

### Layout

- **Header**: `src/components/layout/Header.tsx`
- **Footer**: `src/components/layout/Footer.tsx`
- **Root Layout**: `src/app/layout.tsx`

### Typography

Add custom fonts in `tailwind.config.ts`:

```typescript
fontFamily: {
  sans: ['YourFont', 'system-ui', 'sans-serif'],
}
```

## Pages

- **Homepage** (`/`) - Hero, featured products, menu preview
- **Products** (`/products`) - All coffee products
- **Menu** (`/menu`) - Café menu (hot, cold, food)
- **Locations** (`/locations`) - Store locations
- **About** (`/about`) - Company info and team

## API Integration

The WordPress API client (`src/lib/wordpress.ts`) provides functions:

- `getProducts()` - All products
- `getFeaturedProducts()` - Featured products only
- `getMenuByCategory()` - Menu grouped by category
- `getLocations()` - All locations
- `getTeamMembers()` - Team members

## Development

```bash
# Development
npm run dev

# Build for production
npm run build

# Start production server
npm start

# Lint
npm run lint
```

## Deployment

See [DEPLOYMENT.md](./DEPLOYMENT.md) for comprehensive deployment instructions including:

- Environment configuration for different environments
- Vercel deployment (recommended)
- Self-hosted/VPS deployment
- Docker deployment
- Troubleshooting image loading issues
- Security considerations

Quick start:
1. Push to GitHub
2. Import project in Vercel
3. Set environment variables in Vercel Dashboard
4. Deploy

## API Endpoints Reference

### Custom WordPress REST API Endpoints

All custom endpoints are defined in `themes/CoffeeShop/inc/rest-api.php` and use the namespace `coffee-shop/v1`:

| Endpoint | Method | Purpose | Returns |
|----------|--------|---------|---------|
| `/coffee-shop/v1/products` | GET | All coffee products with complete metadata | Array of products with price, roast_level, origin, etc. |
| `/coffee-shop/v1/products/featured` | GET | Featured products only | Filtered array of featured products |
| `/coffee-shop/v1/menu` | GET | Menu items grouped by category (hot/cold/food) | Object with hot, cold, food arrays |
| `/coffee-shop/v1/locations` | GET | All café locations with complete metadata | Array of locations with address, phone, email, hours |
| `/coffee-shop/v1/locations/nearest` | GET | Nearest location (placeholder) | Single location object |

**Important**: The custom endpoints return complete metadata including:
- `price` (float)
- `roast_level` (string)
- `origin` (string)
- `tasting_notes` (string)
- `sku` (string)
- `stock_status` (string)
- `featured_image_url` (object with thumbnail, medium, large, full)

The standard WordPress REST API endpoints (`/wp/v2/coffee_product`) do NOT include these meta fields by default.

## Troubleshooting

### Product Details Not Displaying on Products Page

**Symptoms**: The products page shows only titles and prices are missing (roast level, origin, etc. not displayed)

**Root Cause**: The frontend is using an endpoint that doesn't include the complete metadata, or the endpoint doesn't exist.

**Solution**:

1. Verify the `/coffee-shop/v1/products` endpoint exists in `themes/CoffeeShop/inc/rest-api.php`
2. Test the endpoint: `curl http://your-domain/wp-json/coffee-shop/v1/products`
3. Ensure the endpoint callback function `coffeeshop_get_all_products()` is defined
4. The function should fetch all coffee products and include all meta fields (see above table)
5. Clear frontend cache and rebuild if needed

**Reference Implementation**: See `themes/CoffeeShop/inc/rest-api.php` lines 25-30 (endpoint registration) and lines 89-125 (callback function)

### Featured Products Working but All Products Not Working

This typically means the `/coffee-shop/v1/products` endpoint is missing while `/coffee-shop/v1/products/featured` exists.

The solution is to create the `/products` endpoint with the same structure as the featured endpoint, but without the `meta_query` filter.

## Notes

- ISR revalidation is set to 60 seconds
- Images are optimized via Next.js Image component
- CORS is configured in WordPress theme
- TypeScript ensures type safety with WordPress data
- **WordPress URL Configuration**: When changing WordPress domains/URLs, update both `.env.local` and `next.config.js` remotePatterns
- **Custom Endpoints**: All custom REST API endpoints must be registered in `themes/CoffeeShop/inc/rest-api.php` - verify this file has not been accidentally deleted or modified

## License

Private project
