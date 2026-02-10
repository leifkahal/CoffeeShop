/**
 * WordPress REST API Client
 */

import type { Product, MenuItem, Location, TeamMember, MenuByCategory } from '@/types/wordpress'

const API_URL = process.env.NEXT_PUBLIC_WORDPRESS_API_URL || 'http://coffee-shop.local/wp-json'

/**
 * Generic fetch function with error handling
 */
async function fetchAPI(endpoint: string, options?: RequestInit) {
  const url = `${API_URL}${endpoint}`

  try {
    const res = await fetch(url, {
      ...options,
      next: { revalidate: 60 }, // ISR: revalidate every 60 seconds
    })

    if (!res.ok) {
      throw new Error(`API error: ${res.status} ${res.statusText}`)
    }

    return res.json()
  } catch (error) {
    console.error(`Error fetching ${url}:`, error)
    throw error
  }
}

/**
 * Safe fetch function that doesn't throw errors (for optional data like contact info)
 */
async function fetchAPIOptional(endpoint: string, options?: RequestInit) {
  const url = `${API_URL}${endpoint}`

  try {
    const res = await fetch(url, {
      ...options,
      next: { revalidate: 60 },
    })

    if (!res.ok) {
      return null
    }

    return res.json()
  } catch (error) {
    console.error(`Error fetching ${url}:`, error)
    return null
  }
}

/**
 * Get all products
 */
export async function getProducts(): Promise<Product[]> {
  try {
    return await fetchAPI('/coffee-shop/v1/products')
  } catch (error) {
    console.error('Error fetching products:', error)
    return []
  }
}

/**
 * Get a single product by slug
 */
export async function getProductBySlug(slug: string): Promise<Product | null> {
  try {
    const products = await fetchAPI(`/wp/v2/coffee_product?slug=${slug}`)
    return products[0] || null
  } catch (error) {
    console.error(`Error fetching product ${slug}:`, error)
    return null
  }
}

/**
 * Get featured products
 */
export async function getFeaturedProducts(): Promise<Product[]> {
  try {
    return await fetchAPI('/coffee-shop/v1/products/featured')
  } catch (error) {
    console.error('Error fetching featured products:', error)
    // Fallback to regular products endpoint
    try {
      const allProducts = await getProducts()
      return allProducts.filter(p => p.meta?.featured_product)
    } catch {
      return []
    }
  }
}

/**
 * Get all menu items
 */
export async function getMenuItems(): Promise<MenuItem[]> {
  try {
    return await fetchAPI('/wp/v2/menu_item?per_page=100')
  } catch (error) {
    console.error('Error fetching menu items:', error)
    return []
  }
}

/**
 * Get featured menu items
 * Handles various truthy values from WordPress meta (boolean, string "1", "true", etc.)
 */
export async function getFeaturedMenuItems(): Promise<MenuItem[]> {
  try {
    const allMenuItems = await getMenuItems()
    return allMenuItems.filter(item => {
      const featuredValue = item.meta?.featured_menu_item
      // Handle various truthy values from WordPress (boolean, string "1"/"0", number)
      return featuredValue === true || featuredValue === '1' || featuredValue === 'true' || featuredValue === 1
    })
  } catch (error) {
    console.error('Error fetching featured menu items:', error)
    return []
  }
}

/**
 * Get menu items grouped by category
 */
export async function getMenuByCategory(): Promise<MenuByCategory> {
  try {
    return await fetchAPI('/coffee-shop/v1/menu')
  } catch (error) {
    console.error('Error fetching menu by category:', error)
    // Fallback: organize manually
    const items = await getMenuItems()
    return {
      hot: items.filter(item => item.meta?.category === 'hot'),
      cold: items.filter(item => item.meta?.category === 'cold'),
      food: items.filter(item => item.meta?.category === 'food'),
    }
  }
}

/**
 * Get all locations
 */
export async function getLocations(): Promise<Location[]> {
  try {
    return await fetchAPI('/coffee-shop/v1/locations')
  } catch (error) {
    console.error('Error fetching locations:', error)
    return []
  }
}

/**
 * Get a single location by slug
 */
export async function getLocationBySlug(slug: string): Promise<Location | null> {
  try {
    const locations = await fetchAPI(`/wp/v2/cafe_location?slug=${slug}`)
    return locations[0] || null
  } catch (error) {
    console.error(`Error fetching location ${slug}:`, error)
    return null
  }
}

/**
 * Get all team members
 */
export async function getTeamMembers(): Promise<TeamMember[]> {
  try {
    return await fetchAPI('/wp/v2/team_member?per_page=100')
  } catch (error) {
    console.error('Error fetching team members:', error)
    return []
  }
}

/**
 * Get contact information with fallback to defaults
 */
export async function getContactInfo() {
  const result = await fetchAPIOptional('/coffee-shop/v1/contact')

  // Return fetched data or defaults
  return result || {
    general_email: 'contact@coffee-shop.local',
    general_phone: '(555) 123-4567',
    support_email: 'support@coffee-shop.local',
    support_phone: '(555) 123-4568',
    business_hours: 'Monday - Friday: 6am - 8pm\nSaturday - Sunday: 7am - 9pm',
    address: '123 Main Street, Anytown, USA',
  }
}

/**
 * Strip HTML tags from string
 */
export function stripHtml(html: string): string {
  return html.replace(/<[^>]*>/g, '')
}

/**
 * Format price
 */
export function formatPrice(price: number): string {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(price)
}
