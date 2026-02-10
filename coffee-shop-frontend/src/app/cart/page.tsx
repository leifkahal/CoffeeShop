'use client'

import Image from 'next/image'
import Link from 'next/link'
import { useState } from 'react'
import { useCart } from '@/context/CartContext'
import PaymentForm from '@/components/PaymentForm'

const TAX_RATE = 0.08

export default function CartPage() {
  const { items, updateQuantity, removeFromCart, cartTotal, clearCart } = useCart()
  const [fulfillmentMethod, setFulfillmentMethod] = useState<'pickup' | 'shipping'>('pickup')
  const [shippingData, setShippingData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    address: '',
    city: '',
    state: '',
    zip: '',
  })
  const [orderPlaced, setOrderPlaced] = useState(false)

  const taxAmount = cartTotal * TAX_RATE
  const grandTotal = cartTotal + taxAmount

  const handleQuantityChange = (id: number, newQuantity: number) => {
    if (newQuantity > 0) {
      updateQuantity(id, newQuantity)
    } else {
      removeFromCart(id)
    }
  }

  const canCheckout = () => {
    if (fulfillmentMethod === 'shipping') {
      return (
        shippingData.firstName &&
        shippingData.lastName &&
        shippingData.email &&
        shippingData.address &&
        shippingData.city &&
        shippingData.state &&
        shippingData.zip
      )
    }
    return true
  }

  if (items.length === 0 && !orderPlaced) {
    return (
      <section className="mt-40 min-h-screen flex justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-white/85 mb-4 uppercase">Your Cart is Empty</h1>
          <p className="text-primary/70 mb-8 max-w-md">
            Start browsing our menu and coffee products to add items to your cart.
          </p>
          <Link
            href="/menu"
            className="inline-block bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-primary/90 transition-colors"
          >
            Continue Shopping
          </Link>
        </div>
      </section>
    )
  }

  if (orderPlaced) {
    return (
      <section className="section min-h-screen flex items-center justify-center">
        <div className="text-center">
          <h1 className="text-4xl font-bold text-white/85 mb-4 uppercase">Order Confirmed!</h1>
          <p className="text-primary/70 mb-8 max-w-md">
            Thank you for your order. A confirmation email has been sent to your email address.
          </p>
          <div className="space-y-2 mb-8">
            <p className="text-sm text-white/75">Order ID: #{Math.random().toString(36).substr(2, 9).toUpperCase()}</p>
            <p className="text-sm text-white/75">Fulfillment: {fulfillmentMethod === 'pickup' ? 'Pickup' : 'Shipping'}</p>
          </div>
          <Link
            href="/menu"
            className="inline-block bg-primary text-white font-bold py-3 px-8 rounded-lg hover:bg-primary/90 transition-colors"
          >
            Continue Shopping
          </Link>
        </div>
      </section>
    )
  }

  return (
    <section className="section min-h-screen py-8">
      <div className="container-custom max-w-2xl space-y-2">
        {/* Header */}

        {/* Items Section */}
        <div className="p-0">
          <h2 className="text-2xl font-bold text-white/85 mb-6 uppercase tracking-tight border-b-2 border-accent/10 max-w-max mx-auto">Shopping Cart</h2>
          <div className="space-y-2">
            {items.map((item) => (
              <div key={item.id} className="card flex flex-col p-[2px]">
                <div className="flex overflow-hidden flex-1">
                  {/* Image */}
                  <div className="relative w-32 shrink-0 bg-gray-100">
                    {item.image ? (
                      <Image src={item.image} alt={item.title} fill className="object-cover rounded-l-md" />
                    ) : (
                      <div className="w-full h-full bg-primary/10 flex items-center justify-center">
                        <svg className="w-10 h-10 text-primary/30" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M2 21V19H20V21H2ZM20 8V5H22V8C22 9.1 21.1 10 20 10V8ZM18 3H4V14C4 15.1 4.9 16 6 16H16C17.1 16 18 15.1 18 14V3ZM6 1H18C18 1 20 1 20 3H2C2 1 4 1 6 1Z" />
                        </svg>
                      </div>
                    )}
                  </div>

                  {/* Content */}
                  <div className="px-4 pt-4 pb-4 flex-1 flex flex-col justify-between">
                    {/* Header with title and price */}
                    <div className="flex items-start justify-between mb-2">
                      <h3 className="max-w-max border-accent/10 border-b-2 font-semibold text-primary/75 uppercase leading-tight tracking-tight">
                        {item.title}
                      </h3>
                      <span className="text-sm text-gold font-bold mr-2 shrink-0">
                        ${(item.price * item.quantity).toFixed(2)}
                      </span>
                    </div>

                    {/* Description */}
                    {item.description && (
                      <div
                        className="text-xs text-primary/70 mb-3"
                        dangerouslySetInnerHTML={{ __html: item.description }}
                      />
                    )}

                    {/* Controls */}
                    <div className="flex items-start justify-between">
                      {/* Quantity Controls */}
                      <div className="flex items-center justify-center border border-primary/20 rounded w-fit">
                        <button
                          onClick={() => handleQuantityChange(item.id, item.quantity - 1)}
                          className="px-2 py-0 hover:bg-primary/10 transition-colors"
                        >
                          −
                        </button>
                        <input
                          type="number"
                          min="1"
                          value={item.quantity}
                          onChange={(e) => {
                            const val = parseInt(e.target.value) || 1
                            handleQuantityChange(item.id, Math.max(1, val))
                          }}
                          className="max-sm:w-16 md:w-10 px-1 py-1 md:text-xs text-center bg-white/75 border-l border-r border-primary/20 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none [&]:m-0"
                        />
                        <button
                          onClick={() => handleQuantityChange(item.id, item.quantity + 1)}
                          className="px-2 py-0 hover:bg-primary/10 transition-colors"
                        >
                          +
                        </button>
                      </div>

                      {/* Remove Button */}
                      <button
                        onClick={() => removeFromCart(item.id)}
                        className="px-3 py-1 text-xs text-red-600 hover:text-red-600 border border-red-400/30 hover:border-red-600 rounded transition-colors font-semibold ml-2"
                      >
                        Remove
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        
        <div className="bg-white/50 rounded-lg p-0">
{/* Fulfillment Method Section */}
        <div className="bg-white/10 rounded-lg p-6 mb-0">
          <h2 className="text-lg tracking-tight max-w-max border-accent/10 border-b-2 font-semibold text-primary/70 mb-2 uppercase">Fulfillment</h2>
          <div className="space-y-3 mb-4">
            <label className="flex items-center gap-4 px-4 py-2 border border-white/20 rounded-lg cursor-pointer bg-white/50 transition-colors">
              <input
                type="radio"
                name="fulfillment"
                value="pickup"
                checked={fulfillmentMethod === 'pickup'}
                onChange={() => setFulfillmentMethod('pickup')}
                className="w-4 h-4"
              />
              <div>
                <p className="font-semibold text-primary/70">Pickup</p>
                <p className="text-sm text-primary/70">Pick up at one of our locations</p>
              </div>
            </label>
            <label className="flex items-center gap-4 px-4 py-2 border border-white/20 rounded-lg cursor-pointer bg-white/50 transition-colors">
              <input
                type="radio"
                name="fulfillment"
                value="shipping"
                checked={fulfillmentMethod === 'shipping'}
                onChange={() => setFulfillmentMethod('shipping')}
                className="w-4 h-4"
              />
              <div>
                <p className="font-semibold text-primary/70">Shipping</p>
                <p className="text-sm text-primary/70">Have it delivered to your address</p>
              </div>
            </label>
        </div>

        {/* Shipping Address Section - Only show if shipping selected */}
        {fulfillmentMethod === 'shipping' && (
          <div className="w-full bg-white/50 border border-white/10 rounded-lg p-6">
            <h2 className="text-lg tracking-tight max-w-max border-accent/10 border-b-2 font-semibold text-primary/75 mb-6 uppercase">Shipping Address</h2>
            <form className="space-y-2">
              <div className="grid grid-cols-2 gap-3">
                <input
                  type="text"
                  placeholder="First Name"
                  value={shippingData.firstName}
                  onChange={(e) => setShippingData({ ...shippingData, firstName: e.target.value })}
                  className="px-3 py-2 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
                />
                <input
                  type="text"
                  placeholder="Last Name"
                  value={shippingData.lastName}
                  onChange={(e) => setShippingData({ ...shippingData, lastName: e.target.value })}
                  className="px-3 py-2 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
                />
              </div>
              <input
                type="email"
                placeholder="Email"
                value={shippingData.email}
                onChange={(e) => setShippingData({ ...shippingData, email: e.target.value })}
                className="w-full px-3 py-2 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
              />
              <input
                type="text"
                placeholder="Street Address"
                value={shippingData.address}
                onChange={(e) => setShippingData({ ...shippingData, address: e.target.value })}
                className="w-full px-3 py-2 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
              />
              <div className="grid grid-cols-4 gap-2">
                <input
                  type="text"
                  placeholder="City"
                  value={shippingData.city}
                  onChange={(e) => setShippingData({ ...shippingData, city: e.target.value })}
                  className="col-span-2 px-2 py-2 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
                />
                <input
                  type="text"
                  placeholder="State"
                  value={shippingData.state}
                  onChange={(e) => setShippingData({ ...shippingData, state: e.target.value })}
                  className="px-2 py-1 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
                />
                <input
                  type="text"
                  placeholder="ZIP"
                  value={shippingData.zip}
                  onChange={(e) => setShippingData({ ...shippingData, zip: e.target.value })}
                  className="px-2 py-1 bg-white/50 border border-white/20 rounded text-sm text-primary/75 placeholder-primary/50 outline-none focus:border-primary/40 transition-colors"
                />
              </div>
            </form>
          </div>
        )}
        {/* Payment Section */}
        <h2 className="text-lg tracking-tight border-accent/10 border-b-2 max-w-max font-semibold text-primary/75 mb-2 uppercase mt-8">Payment</h2>
          <PaymentForm
            onSuccess={() => {
              clearCart()
              setOrderPlaced(true)
            }}
            onError={() => {}}/>
        </div>
        </div>
      </div>
    </section>
  )
}
