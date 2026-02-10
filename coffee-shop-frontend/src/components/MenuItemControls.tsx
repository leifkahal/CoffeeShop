'use client'

import { useState } from 'react'

/**
 * MenuItemControls Component
 *
 * A client-side component that provides quantity selection and add-to-cart functionality
 * for menu items displayed on the menu page. Used in horizontal card layouts.
 *
 * Behavior:
 * - Initially displays only an "Add to Cart" button
 * - Clicking "Add to Cart" hides the button and reveals a quantity selector (−/input/+)
 * - Clicking "−" when quantity is 1 hides the selector and shows "Add to Cart" again
 * - Quantity resets to 1 when the selector is hidden
 *
 * @param {Object} props - Component props
 * @param {number} props.id - Unique identifier for the menu item (for future cart integration)
 * @param {string} props.title - Display name of the menu item
 *
 * @example
 * <MenuItemControls id={item.id} title={item.title.rendered} />
 */

interface MenuItemControlsProps {
  /** Unique identifier for the menu item */
  id: number
  /** Display name of the menu item (used in add to cart logging) */
  title: string
  /** Price of the menu item */
  price?: number
  /** Image URL of the menu item */
  image?: string
  /** Description of the menu item */
  description?: string
  /** Callback fired when "Add to Cart" button is clicked (before quantity selector shows) */
  onAddToCart?: (id: number, title: string, quantity: number, price: number, image?: string, description?: string) => void
  /** Callback fired when quantity changes via +/− buttons or direct input */
  onQuantityChange?: (id: number, quantity: number) => void
  /** Callback fired when item is removed (quantity at 1, − clicked) */
  onRemove?: (id: number) => void
}

export function MenuItemControls({ id, title, price = 0, image, description, onAddToCart, onQuantityChange, onRemove }: MenuItemControlsProps) {
  const [quantity, setQuantity] = useState(1)
  const [isSelected, setIsSelected] = useState(false)

  /**
   * Handles direct input changes to the quantity field
   * Validates input to ensure minimum quantity of 1
   */
  const handleQuantityChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const value = parseInt(e.target.value) || 1
    const newQuantity = Math.max(1, value)
    setQuantity(newQuantity)
    onQuantityChange?.(id, newQuantity)
  }

  /**
   * Handles add to cart button click
   * Shows the quantity selector and fires callback
   */
  const handleAddToCart = () => {
    setIsSelected(true)
    onAddToCart?.(id, title, quantity, price, image, description)
  }

  return (
    <div className="py-3 flex flex-col md:flex-row md:items-center gap-3">
      {!isSelected ? (
        <button
          onClick={handleAddToCart}
          className="w-full md:flex-1 text-xs max-sm:text-[0.85rem] md:min-w-max btn-tertiary font-semibold py-2 px-2 rounded transition-colors"
        >
          Add to Cart
        </button>
      ) : (
        <div className="flex mb-1.5 items-center justify-center border border-primary/20 rounded w-fit mx-auto">
          <button
            onClick={() => {
              if (quantity === 1) {
                setIsSelected(false)
                onRemove?.(id)
              } else {
                const newQuantity = quantity - 1
                setQuantity(newQuantity)
                onQuantityChange?.(id, newQuantity)
              }
            }}
            className="px-2 py-0 hover:bg-primary/10 transition-colors"
          >
            −
          </button>
          <input
            type="number"
            min="1"
            value={quantity}
            onChange={handleQuantityChange}
            className="max-sm:w-16 md:w-10 px-1 py-1 md:text-xs text-center bg-white/75 border-l border-r border-primary/20 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [&]:m-0"
          />
          <button
            onClick={() => {
              const newQuantity = quantity + 1
              setQuantity(newQuantity)
              onQuantityChange?.(id, newQuantity)
            }}
            className="px-2 py-0 hover:bg-primary/10 transition-colors"
          >
            +
          </button>
        </div>
      )}
    </div>
  )
}
