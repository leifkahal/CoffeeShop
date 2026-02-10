'use client'

import Image from 'next/image'
import { useState } from 'react'
import { formatPrice } from '@/lib/wordpress'

interface MenuItemCardProps {
  id: number
  title: string
  image?: string
  price: number
  content?: string
  allergens?: string
}

export function MenuItemCard({ id, title, image, price, content, allergens }: MenuItemCardProps) {
  const [quantity, setQuantity] = useState(1)

  const handleQuantityChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = parseInt(e.target.value) || 1
    setQuantity(Math.max(1, value))
  }

  const handleAddToCart = () => {
    console.log(`Added ${quantity} of ${title} to cart`)
  }

  return (
    <div className="card flex flex-col">
      <div className="relative w-full h-32">
        {image ? (
          <Image src={image} alt={title} fill className="object-cover" />
        ) : (
          <div className="w-full h-full bg-primary/10 flex items-center justify-center">
            <svg className="w-10 h-10 text-primary/30" fill="currentColor" viewBox="0 0 24 24">
              <path d="M2 21V19H20V21H2ZM20 8V5H22V8C22 9.1 21.1 10 20 10V8ZM18 3H4V14C4 15.1 4.9 16 6 16H16C17.1 16 18 15.1 18 14V3ZM6 1H18C18 1 20 1 20 3H2C2 1 4 1 6 1Z" />
            </svg>
          </div>
        )}
      </div>
      <div className="p-4 flex flex-col flex-1">
        <div className="flex items-start justify-between border-b-2 border-accent/10 pb-1 mb-1">
          <h3 className="font-xs font-semibold text-primary/70 uppercase leading-none tracking-tighter">
            {title}
          </h3>
          <span className="text-accent font-semibold leading-none">
            {formatPrice(price)}
          </span>
        </div>
        {content && (
          <div
            className="text-primary/75 text-sm mb-3 tracking-tight"
            dangerouslySetInnerHTML={{ __html: content }}
          />
        )}
        <p className="text-sm text-gray-500 mb-4 flex-1">
          Allergens: {allergens || 'None'}
        </p>
        <div className="flex items-center gap-3">
          <input
            type="number"
            min="1"
            value={quantity}
            onChange={handleQuantityChange}
            className="w-16 px-2 py-1 border border-primary/20 rounded text-center"
          />
          <button
            onClick={handleAddToCart}
            className="flex-1 md:text-xs md:min-w-max btn-tertiary font-semibold py-2 px-2 max-sm:ml-8 rounded transition-colors"
          >
            Add to Cart
          </button>
        </div>
      </div>
    </div>
  )
}
