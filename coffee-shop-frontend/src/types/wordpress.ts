/**
 * WordPress REST API Types
 */

export interface WP_Post {
  id: number
  slug: string
  title: { rendered: string }
  content: { rendered: string }
  excerpt: { rendered: string }
  featured_media: number
  featured_image_url?: {
    thumbnail?: string
    medium?: string
    large?: string
    full?: string
  }
}

export interface Product extends WP_Post {
  meta: {
    price: number
    sku: string
    roast_level: 'light' | 'medium' | 'dark'
    origin: string
    tasting_notes: string
    stock_status: 'in-stock' | 'out-of-stock'
    featured_product: boolean
  }
}

export interface MenuItem extends WP_Post {
  image?: string
  meta: {
    category: 'hot' | 'cold' | 'food'
    price: number
    ingredients: string
    allergens: string
    availability: string
    featured_menu_item: boolean
    description: string
  }
}

export interface Location extends WP_Post {
  meta: {
    address_street: string
    address_city: string
    address_state: string
    address_zip: string
    phone: string
    email: string
    hours: string
    latitude: string
    longitude: string
  }
}

export interface TeamMember extends WP_Post {
  meta: {
    position: string
    bio: string
    instagram: string
    twitter: string
    linkedin: string
  }
}

export interface MenuByCategory {
  hot: MenuItem[]
  cold: MenuItem[]
  food: MenuItem[]
}

export interface ContactInfo extends WP_Post {
  meta: {
    general_email: string
    general_phone: string
    support_email: string
    support_phone: string
    business_hours: string
    address: string
  }
}
