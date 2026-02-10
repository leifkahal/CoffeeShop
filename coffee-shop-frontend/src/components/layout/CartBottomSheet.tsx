'use client'

import { useState } from 'react'
import Image from 'next/image'
import { useCart } from '@/context/CartContext'
import CartCheckout from '../CartCheckout'

const TAX_RATE = 0.08 // 8% tax

export default function CartBottomSheet() {
  const { items, cartTotal, cartCount } = useCart()
  const [isExpanded, setIsExpanded] = useState(false)
  const [showCheckout, setShowCheckout] = useState(false)

  const taxAmount = cartTotal * TAX_RATE
  const grandTotal = cartTotal + taxAmount

  if (cartCount === 0) return null

  return (
    <>
      {/* Bottom sheet overlay */}
      {isExpanded && (
        <div
          className="fixed inset-0 bg-black/50 z-40"
          onClick={() => {
            setIsExpanded(false)
            setShowCheckout(false)
          }}
        />
      )}

      {/* Bottom sheet container */}
      <div
        className={`fixed bottom-0 left-0 right-0 bg-white rounded-t-2xl shadow-2xl z-50 transition-all duration-300 ease-out ${
          isExpanded ? 'inset-0' : 'max-h-24'
        }`}
      >
        {/* Collapsed preview */}
        {!isExpanded && (
          <div
            onClick={() => setIsExpanded(true)}
            className="p-4 cursor-pointer"
          >
            <div className="flex justify-between items-center">
              <div>
                <p className="text-sm text-gray-600">Items in cart</p>
                <p className="text-lg font-semibold">{cartCount} item{cartCount !== 1 ? 's' : ''}</p>
              </div>
              <div className="text-right">
                <p className="text-xs text-gray-600">Total</p>
                <p className="text-lg font-semibold">${grandTotal.toFixed(2)}</p>
              </div>
            </div>
          </div>
        )}

        {/* Expanded view */}
        {isExpanded && !showCheckout && (
          <div className="flex flex-col h-full">
            {/* Header */}
            <div className="flex justify-between items-center p-4 border-b">
              <h2 className="text-xl font-bold">Your Cart</h2>
              <button
                onClick={() => setIsExpanded(false)}
                className="text-2xl"
              >
                ✕
              </button>
            </div>

            {/* Cart items list */}
            <div className="flex-1 overflow-y-auto p-4 space-y-3">
              {items.map((item) => (
                <div key={item.id} className="flex gap-3 pb-3 border-b last:border-b-0">
                  {/* Thumbnail */}
                  <div className="w-16 h-16 shrink-0 rounded overflow-hidden bg-gray-100">
                    {item.image ? (
                      <Image src={item.image} alt={item.title} width={64} height={64} className="w-full h-full object-cover" />
                    ) : (
                      <div className="w-full h-full flex items-center justify-center text-gray-400">
                        <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M2 21V19H20V21H2ZM20 8V5H22V8C22 9.1 21.1 10 20 10V8ZM18 3H4V14C4 15.1 4.9 16 6 16H16C17.1 16 18 15.1 18 14V3ZM6 1H18C18 1 20 1 20 3H2C2 1 4 1 6 1Z" />
                        </svg>
                      </div>
                    )}
                  </div>
                  {/* Item details */}
                  <div className="flex-1 min-w-0">
                    <p className="font-semibold text-sm truncate">{item.title}</p>
                    <p className="text-xs text-gray-600 mb-1">Qty: {item.quantity}</p>
                    <p className="text-sm font-medium">${(item.price * item.quantity).toFixed(2)}</p>
                  </div>
                </div>
              ))}
            </div>

            {/* Pricing summary */}
            <div className="p-4 border-t space-y-2 bg-gray-50">
              <div className="flex justify-between text-sm">
                <span className="text-gray-600">Subtotal</span>
                <span>${cartTotal.toFixed(2)}</span>
              </div>
              <div className="flex justify-between text-sm">
                <span className="text-gray-600">Tax (8%)</span>
                <span>${taxAmount.toFixed(2)}</span>
              </div>
              <div className="flex justify-between font-bold text-lg border-t pt-2">
                <span>Total</span>
                <span>${grandTotal.toFixed(2)}</span>
              </div>
            </div>

            {/* Checkout button */}
            <div className="p-4 border-t">
              <button
                onClick={() => setShowCheckout(true)}
                className="w-full bg-primary text-white font-bold py-3 rounded-lg hover:bg-primary/90 transition-colors"
              >
                Proceed to Checkout
              </button>
            </div>
          </div>
        )}

        {/* Checkout mode */}
        {isExpanded && showCheckout && (
          <CartCheckout
            onBack={() => setShowCheckout(false)}
            onClose={() => {
              setIsExpanded(false)
              setShowCheckout(false)
            }}
          />
        )}
      </div>
    </>
  )
}
