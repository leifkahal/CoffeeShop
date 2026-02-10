'use client'

import { useState } from 'react'
import { useCart } from '@/context/CartContext'
import PaymentForm from './PaymentForm'

interface CartCheckoutProps {
  onBack: () => void
  onClose: () => void
}

type CheckoutStep = 'items' | 'shipping' | 'payment' | 'success'

export default function CartCheckout({ onBack, onClose }: CartCheckoutProps) {
  const { items, updateQuantity, removeFromCart, clearCart } = useCart()
  const [currentStep, setCurrentStep] = useState<CheckoutStep>('items')
  const [paymentError, setPaymentError] = useState('')
  const [shippingData, setShippingData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    address: '',
    city: '',
    state: '',
    zip: '',
  })

  const handleQuantityChange = (id: number, newQuantity: number) => {
    if (newQuantity > 0) {
      updateQuantity(id, newQuantity)
    } else {
      removeFromCart(id)
    }
  }

  const handleNext = () => {
    if (currentStep === 'items') {
      setCurrentStep('shipping')
    } else if (currentStep === 'shipping') {
      setCurrentStep('payment')
    }
  }

  const handlePrevious = () => {
    if (currentStep === 'shipping') {
      setCurrentStep('items')
    } else if (currentStep === 'payment') {
      setCurrentStep('shipping')
    }
  }

  const canProceed = () => {
    if (currentStep === 'shipping') {
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

  return (
    <div className="flex flex-col h-full">
      {/* Header with back button */}
      <div className="flex justify-between items-center p-4 border-b bg-gray-50">
        <button onClick={onBack} className="text-lg">
          ← Back
        </button>
        <h2 className="text-xl font-bold">Checkout</h2>
        <button onClick={onClose} className="text-2xl">
          ✕
        </button>
      </div>

      {/* Step indicators */}
      <div className="flex justify-between px-4 pt-4 pb-2">
        {(['items', 'shipping', 'payment'] as const).map((step) => (
          <div key={step} className="flex flex-col items-center flex-1">
            <div
              className={`w-8 h-8 rounded-full flex items-center justify-center font-bold transition-colors ${
                currentStep === step
                  ? 'bg-primary text-white'
                  : currentStep > step
                    ? 'bg-green-500 text-white'
                    : 'bg-gray-300 text-gray-600'
              }`}
            >
              {['items', 'shipping', 'payment'].indexOf(step) + 1}
            </div>
            <span className="text-xs mt-1 capitalize">{step}</span>
          </div>
        ))}
      </div>

      {/* Content */}
      <div className="flex-1 overflow-y-auto p-4">
        {/* Items step */}
        {currentStep === 'items' && (
          <div>
            <h3 className="font-bold text-lg mb-4">Review Your Items</h3>
            {items.map((item) => (
              <div key={item.id} className="flex justify-between items-center py-3 border-b last:border-b-0">
                <div className="flex-1">
                  <p className="font-medium">{item.title}</p>
                  <p className="text-sm text-gray-600">Item #{item.id}</p>
                </div>
                <div className="flex items-center gap-2">
                  <button
                    onClick={() => handleQuantityChange(item.id, item.quantity - 1)}
                    className="px-2 py-1 border border-gray-300 rounded hover:bg-gray-100"
                  >
                    −
                  </button>
                  <input
                    type="number"
                    min="1"
                    value={item.quantity}
                    onChange={(e) => {
                      const value = parseInt(e.target.value) || 1
                      handleQuantityChange(item.id, Math.max(1, value))
                    }}
                    className="w-12 px-1 py-1 text-center border border-gray-300 rounded"
                  />
                  <button
                    onClick={() => handleQuantityChange(item.id, item.quantity + 1)}
                    className="px-2 py-1 border border-gray-300 rounded hover:bg-gray-100"
                  >
                    +
                  </button>
                </div>
              </div>
            ))}
          </div>
        )}

        {/* Shipping step */}
        {currentStep === 'shipping' && (
          <div>
            <h3 className="font-bold text-lg mb-4">Shipping Address</h3>
            <form className="space-y-3">
              <div className="grid grid-cols-2 gap-3">
                <input
                  type="text"
                  placeholder="First Name"
                  value={shippingData.firstName}
                  onChange={(e) => setShippingData({ ...shippingData, firstName: e.target.value })}
                  className="px-3 py-2 border border-gray-300 rounded text-sm"
                />
                <input
                  type="text"
                  placeholder="Last Name"
                  value={shippingData.lastName}
                  onChange={(e) => setShippingData({ ...shippingData, lastName: e.target.value })}
                  className="px-3 py-2 border border-gray-300 rounded text-sm"
                />
              </div>
              <input
                type="email"
                placeholder="Email"
                value={shippingData.email}
                onChange={(e) => setShippingData({ ...shippingData, email: e.target.value })}
                className="w-full px-3 py-2 border border-gray-300 rounded text-sm"
              />
              <input
                type="text"
                placeholder="Address"
                value={shippingData.address}
                onChange={(e) => setShippingData({ ...shippingData, address: e.target.value })}
                className="w-full px-3 py-2 border border-gray-300 rounded text-sm"
              />
              <div className="grid grid-cols-2 gap-3">
                <input
                  type="text"
                  placeholder="City"
                  value={shippingData.city}
                  onChange={(e) => setShippingData({ ...shippingData, city: e.target.value })}
                  className="px-3 py-2 border border-gray-300 rounded text-sm"
                />
                <input
                  type="text"
                  placeholder="State"
                  value={shippingData.state}
                  onChange={(e) => setShippingData({ ...shippingData, state: e.target.value })}
                  className="px-3 py-2 border border-gray-300 rounded text-sm"
                />
              </div>
              <input
                type="text"
                placeholder="ZIP Code"
                value={shippingData.zip}
                onChange={(e) => setShippingData({ ...shippingData, zip: e.target.value })}
                className="w-full px-3 py-2 border border-gray-300 rounded text-sm"
              />
            </form>
          </div>
        )}

        {/* Payment step */}
        {currentStep === 'payment' && (
          <div>
            <h3 className="font-bold text-lg mb-4">Payment Information</h3>
            {paymentError && (
              <div className="bg-red-50 border border-red-200 rounded p-3 mb-4 text-sm text-red-800">
                {paymentError}
              </div>
            )}
            <PaymentForm
              onSuccess={() => {
                clearCart()
                setCurrentStep('success')
              }}
              onError={(error) => setPaymentError(error)}
            />
          </div>
        )}

        {/* Success step */}
        {currentStep === 'success' && (
          <div className="text-center py-8">
            <div className="text-5xl mb-4">✓</div>
            <h3 className="font-bold text-lg mb-2">Order Confirmed!</h3>
            <p className="text-gray-600 mb-6">
              Thank you for your order. A confirmation email has been sent to your email address.
            </p>
            <div className="space-y-2">
              <p className="text-sm text-gray-600">Order ID: #{Math.random().toString(36).substr(2, 9).toUpperCase()}</p>
              <p className="text-sm text-gray-600">Items: {items.length}</p>
            </div>
          </div>
        )}
      </div>

      {/* Footer buttons */}
      {currentStep !== 'success' && (
        <div className="border-t p-4 bg-gray-50 flex gap-3">
          {currentStep !== 'items' && (
            <button
              onClick={handlePrevious}
              className="flex-1 py-3 border border-gray-300 rounded-lg font-semibold hover:bg-gray-100 transition-colors"
            >
              Previous
            </button>
          )}
          {currentStep !== 'payment' && (
            <button
              onClick={handleNext}
              disabled={!canProceed()}
              className={`flex-1 py-3 rounded-lg font-semibold transition-colors ${
                canProceed()
                  ? 'bg-primary text-white hover:bg-primary/90'
                  : 'bg-gray-300 text-gray-600 cursor-not-allowed'
              }`}
            >
              Next
            </button>
          )}
        </div>
      )}
      {currentStep === 'success' && (
        <div className="border-t p-4 bg-gray-50">
          <button
            onClick={onClose}
            className="w-full py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors"
          >
            Continue Shopping
          </button>
        </div>
      )}
    </div>
  )
}
