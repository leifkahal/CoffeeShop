# Deployment Guide

This document covers deployment setup, environment configuration, and important notes for running the CoffeeShop Frontend in different environments.

## Environment Configuration

### WordPress URL Setup

The application connects to a WordPress backend via REST API. The WordPress URL can vary between development, staging, and production environments.

#### Current Configuration (as of Feb 2025)

**Development:**
```env
NEXT_PUBLIC_WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
```

**Note**: The WordPress URL was changed from `http://localhost:10003` to `http://192.168.0.118:10023`. Update your environment variables and `next.config.js` when deploying to different environments.

### Environment Variables

Create a `.env.local` file in the project root with the following variables:

```env
# WordPress REST API URL (required)
# This is used for server-side API calls
WORDPRESS_API_URL=http://your-wordpress-domain/wp-json

# Public WordPress API URL (required)
# This is accessible to the browser and used for client-side operations
NEXT_PUBLIC_WORDPRESS_API_URL=http://your-wordpress-domain/wp-json
```

**Important**:
- `WORDPRESS_API_URL` can be internal/private (used only by the Next.js server)
- `NEXT_PUBLIC_WORDPRESS_API_URL` must be publicly accessible (sent to the browser)

### Image Domain Whitelisting

Next.js requires explicit whitelisting of external image domains for security. Update `next.config.js` whenever you change WordPress domains:

```javascript
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: '192.168.0.118',
        port: '10023',
      },
      // Add other domains as needed:
      // {
      //   protocol: 'https',
      //   hostname: 'your-production-domain.com',
      // },
    ],
  },
}

module.exports = nextConfig
```

**Without this configuration, featured images from WordPress will fail to load.**

## Development Setup

### Local Development

1. Install dependencies:
```bash
npm install
```

2. Create `.env.local` with local WordPress URL:
```env
NEXT_PUBLIC_WORDPRESS_API_URL=http://localhost:10003/wp-json
WORDPRESS_API_URL=http://localhost:10003/wp-json
```

3. Update `next.config.js` to include your local domain:
```javascript
{
  protocol: 'http',
  hostname: 'localhost',
  port: '10003',
},
```

4. Start development server:
```bash
npm run dev
```

Visit [http://localhost:3000](http://localhost:3000)

### Testing with Network IP

To test from other devices on your network:

1. Update `.env.local`:
```env
NEXT_PUBLIC_WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
WORDPRESS_API_URL=http://192.168.0.118:10023/wp-json
```

2. Update `next.config.js`:
```javascript
{
  protocol: 'http',
  hostname: '192.168.0.118',
  port: '10023',
},
```

3. Run development server and access from: `http://<YOUR_DEV_IP>:3000`

## Production Deployment

### Vercel (Recommended)

Vercel is the best platform for Next.js applications.

1. **Push to GitHub**
```bash
git add .
git commit -m "Prepare for deployment"
git push origin main
```

2. **Deploy on Vercel**
   - Go to [vercel.com](https://vercel.com)
   - Click "New Project"
   - Select your GitHub repository
   - Configure project settings

3. **Set Environment Variables**
   - In Vercel Dashboard → Project Settings → Environment Variables
   - Add:
     ```
     NEXT_PUBLIC_WORDPRESS_API_URL=https://your-wordpress-domain/wp-json
     WORDPRESS_API_URL=https://your-wordpress-domain/wp-json
     ```

4. **Configure WordPress Image Domain**
   - Update `next.config.js` before deploying:
     ```javascript
     {
       protocol: 'https',
       hostname: 'your-wordpress-domain.com',
     },
     ```

5. **Deploy**
   - Commit your changes and push to GitHub
   - Vercel will automatically build and deploy

### Self-Hosted/VPS Deployment

1. **Build the application**
```bash
npm install
npm run build
```

2. **Deploy to server**
```bash
# Copy .next folder and public folder to your server
scp -r .next user@server:/app/
scp -r public user@server:/app/
scp package.json package-lock.json user@server:/app/
```

3. **On the server**
```bash
cd /app
npm ci --omit=dev
export NODE_ENV=production
npm start
```

4. **Configure reverse proxy (Nginx example)**
```nginx
server {
    listen 80;
    server_name your-domain.com;

    location / {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}
```

### Docker Deployment

Create a `Dockerfile`:

```dockerfile
FROM node:18-alpine AS base
WORKDIR /app

# Install dependencies
COPY package.json package-lock.json ./
RUN npm ci

# Build
COPY . .
RUN npm run build

# Production image
FROM node:18-alpine
WORKDIR /app
ENV NODE_ENV=production

COPY --from=base /app/node_modules ./node_modules
COPY --from=base /app/.next ./.next
COPY --from=base /app/public ./public
COPY --from=base /app/package.json ./package.json

EXPOSE 3000
CMD ["npm", "start"]
```

Build and run:
```bash
docker build -t coffeeshop-frontend .
docker run -e NEXT_PUBLIC_WORDPRESS_API_URL=https://your-domain/wp-json -p 3000:3000 coffeeshop-frontend
```

## Troubleshooting

### Images Not Loading

**Symptoms**: Featured product images appear broken or don't display

**Causes & Solutions**:

1. **Image domain not whitelisted**
   - Check `next.config.js` has the correct domain/port
   - Update `remotePatterns` array with the WordPress domain
   - Restart the application

2. **WordPress URL incorrect**
   - Verify `NEXT_PUBLIC_WORDPRESS_API_URL` is correct
   - Test the API endpoint: `https://your-wordpress-domain/wp-json/wp/v2/coffee_product`
   - Ensure WordPress is returning image URLs

3. **CORS issues**
   - WordPress CORS headers may need configuration
   - Check WordPress CORS settings in the backend

### API Connection Errors

1. **Verify WordPress is running**
   - Test the API endpoint in your browser
   - Check WordPress logs for errors

2. **Network/Firewall issues**
   - Ensure WordPress domain is accessible from your server
   - Check firewall rules

3. **ISR revalidation failure**
   - The app revalidates data every 60 seconds
   - Check server logs for API errors

## Performance Considerations

- **ISR (Incremental Static Regeneration)**: Set to 60 seconds - adjust in `lib/wordpress.ts` if needed
- **Image Optimization**: Next.js automatically optimizes images
- **Caching**: Static pages are cached with ISR revalidation
- **API Calls**: Minimize API calls by using batch endpoints when possible

## Security Notes

- Never commit `.env.local` to version control
- Use HTTPS in production (especially for API calls)
- Validate environment variables before deployment
- Keep dependencies updated: `npm audit fix`

## Monitoring

### Log Important Information

Add logging for deployment issues:

```bash
# Vercel logs
vercel logs --follow

# Self-hosted logs
tail -f /var/log/your-app/error.log
```

### Common Metrics to Monitor

- API response times
- Image load times
- Build duration
- Deployment success rate

## Rollback Procedure

### Vercel
- Go to Deployments tab
- Click the previous stable deployment
- Click "Promote to Production"

### Self-Hosted
- Keep previous `.next` builds
- Swap symlinks to previous version
- Verify health checks pass

## Support & Debugging

1. Check environment variables are correctly set
2. Verify WordPress API is accessible
3. Review build logs for errors
4. Check client console (F12) for network errors
5. Monitor server logs for API errors
