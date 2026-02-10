'use client'

import { formatPrice } from '@/lib/wordpress'
import { MenuItemControls } from './MenuItemControls'
import { useCart } from '@/context/CartContext'

/**
 * ProductCard Component
 *
 * A client-side component that displays product information in a card format
 * with add-to-cart functionality. Used on the homepage and products page.
 *
 * Integrates with CartContext to manage add to cart, quantity updates, and removals.
 *
 * @param {Object} props - Component props
 * @param {number} props.id - Unique identifier for the product
 * @param {string} props.slug - URL slug for the product
 * @param {string} props.title - Display name of the product
 * @param {number} props.price - Product price
 * @param {string} [props.imageUrl] - URL to the product image
 * @param {string} [props.imageAlt] - Alt text for the product image
 * @param {string} [props.roastLevel] - Coffee roast level (e.g., "Light", "Medium", "Dark")
 * @param {string} [props.origin] - Coffee origin country/region
 * @param {string} [props.category] - Product category (for menu items)
 * @param {string} [props.excerpt] - Short description (HTML allowed)
 */
interface ProductCardProps {
  id: number
  slug: string
  title: string
  price: number
  imageUrl?: string
  imageAlt?: string
  roastLevel?: string
  origin?: string
  category?: string
  excerpt?: string
}

export function ProductCard({
  id,
  title,
  price,
  imageUrl,
  imageAlt,
  roastLevel,
  origin,
  category,
  excerpt,
}: ProductCardProps) {
  const { addToCart, updateQuantity, removeFromCart } = useCart()

  const handleAddToCart = (id: number, title: string, quantity: number, price: number, image?: string) => {
    addToCart(id, title, quantity, price, image)
  }

  const handleQuantityChange = (id: number, quantity: number) => {
    updateQuantity(id, quantity)
  }

  const handleRemove = (id: number) => {
    removeFromCart(id)
  }

  return (
    <div className="card hover:shadow-xl transition-shadow duration-200 h-full flex flex-col">
      {imageUrl && (
        <div className="aspect-square bg-gray-200 relative overflow-hidden">
          <img
            src={imageUrl}
            alt={imageAlt || title}
            className="w-full h-full object-cover"
          />
        </div>
      )}
      <div className="px-4 py-2">
        <div className="flex items-start justify-between border-b-2 border-accent/10 pb-1">
          <h3 className="font-xs font-semibold text-primary/70 uppercase leading-none tracking-tighter">
            {title}
          </h3>
          <span className="text-accent/90 font-semibold tracking-tight leading-none">
            {formatPrice(price)}
          </span>
        </div>
        {category && (
          <span className="inline-block text-primary-light text-sm capitalize font-bold">
            {category}
          </span>
        )}
        {roastLevel && (
          <span className="inline-block text-primary-light text-sm capitalize font-bold">
            {roastLevel} Roast
          </span>
        )}
        {origin && (
          <p className="text-primary/70 text-sm">
            Origin: {origin}
          </p>
        )}
        {excerpt && (
          <div
            className="inline-block text-primary/70 text-sm capitalize leading-none"
            dangerouslySetInnerHTML={{ __html: excerpt }}
          />
        )}
      </div>
      <div className="px-4 py-4 mt-auto">
        <MenuItemControls
          id={id}
          title={title}
          price={price}
          image={imageUrl}
          onAddToCart={handleAddToCart}
          onQuantityChange={handleQuantityChange}
          onRemove={handleRemove}
        />
      </div>
    </div>
  )
}
