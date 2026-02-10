'use client'

import { useState } from 'react'
import { useCart } from '@/context/CartContext'

interface PaymentFormProps {
  onSuccess: () => void
  onError: (error: string) => void
}

const TAX_RATE = 0.08

export default function PaymentForm({ onSuccess, onError }: PaymentFormProps) {
  const { items, cartTotal } = useCart()
  const [isProcessing, setIsProcessing] = useState(false)
  const [paymentMethod, setPaymentMethod] = useState<'card' | 'google' | 'apple'>('card')
  const [showGooglePayModal, setShowGooglePayModal] = useState(false)
  const [showApplePayModal, setShowApplePayModal] = useState(false)
  const [cardData, setCardData] = useState({
    cardNumber: '',
    expiry: '',
    cvc: '',
  })

  const taxAmount = cartTotal * TAX_RATE
  const total = cartTotal + taxAmount
  const grandTotal = cartTotal + taxAmount

  const handleCardChange = (field: string, value: string) => {
    // Basic formatting
    if (field === 'cardNumber') {
      value = value.replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim()
    } else if (field === 'expiry') {
      value = value.replace(/\D/g, '')
      if (value.length >= 2) {
        value = value.slice(0, 2) + '/' + value.slice(2, 4)
      }
    }
    setCardData({ ...cardData, [field]: value })
  }

  const handleTestPayment = async () => {
    // Open modal for digital wallets
    if (paymentMethod === 'google') {
      setShowGooglePayModal(true)
      return
    }

    if (paymentMethod === 'apple') {
      setShowApplePayModal(true)
      return
    }

    // Handle card payment
    setIsProcessing(true)
    try {
      // Simulate payment processing
      await new Promise((resolve) => setTimeout(resolve, 2000))

      // For test mode, accept specific test cards
      const testCards = ['4242424242424242', '5555555555554444', '378282246310005']
      const cleanCardNumber = cardData.cardNumber.replace(/\s/g, '')

      if (!testCards.includes(cleanCardNumber)) {
        throw new Error('Use test card: 4242 4242 4242 4242 for successful payment')
      }

      onSuccess()
    } catch (err) {
      onError(err instanceof Error ? err.message : 'Payment processing failed')
    } finally {
      setIsProcessing(false)
    }
  }

  const handleDigitalWalletConfirm = async () => {
    setIsProcessing(true)
    try {
      await new Promise((resolve) => setTimeout(resolve, 2000))
      onSuccess()
    } catch (err) {
      onError(err instanceof Error ? err.message : 'Payment processing failed')
    } finally {
      setIsProcessing(false)
      setShowGooglePayModal(false)
      setShowApplePayModal(false)
    }
  }

  return (
    <div className="space-y-4">
      {/* Payment method selection */}
      <div className="space-y-2">
        <div className="space-y-2">
          <label className="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer bg-white/50">
            <input
              type="radio"
              name="payment-method"
              value="card"
              checked={paymentMethod === 'card'}
              onChange={(e) => setPaymentMethod(e.target.value as 'card')}
            />
            <span>Credit/Debit Card</span>
          </label>
          <label className="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer bg-white/50">
            <input
              type="radio"
              name="payment-method"
              value="google"
              checked={paymentMethod === 'google'}
              onChange={(e) => setPaymentMethod(e.target.value as 'google')}
            />
            <span>Google Pay (Test Mode)</span>
          </label>
          <label className="flex items-center gap-3 p-3 border border-gray-300 rounded-lg cursor-pointer bg-white/50">
            <input
              type="radio"
              name="payment-method"
              value="apple"
              checked={paymentMethod === 'apple'}
              onChange={(e) => setPaymentMethod(e.target.value as 'apple')}
            />
            <span>Apple Pay (Test Mode)</span>
          </label>
        </div>
      </div>

      {/* Card form for test */}
      {paymentMethod === 'card' && (
        <div className="space-y-3 p-4 bg-stone-900/85 rounded-lg">
          <p className="text-sm tracking-tight text-white/75 font-medium uppercase">Test Card Information</p>
          <p className="text-xs text-white/75">
           <span className="text-white/75 mr-2">Use card number</span>
           <code className="bg-white text-primary px-1 py-0.5 rounded">4242 4242 4242 4242</code>
          </p>
          <input
            type="text"
            placeholder="Card Number"
            value={cardData.cardNumber}
            onChange={(e) => handleCardChange('cardNumber', e.target.value)}
            className="w-full px-3 py-2 border border-gray-300 rounded text-sm"
            maxLength={19}
          />
          <div className="grid grid-cols-2 gap-3">
            <input
              type="text"
              placeholder="MM/YY"
              value={cardData.expiry}
              onChange={(e) => handleCardChange('expiry', e.target.value)}
              className="px-3 py-2 border border-gray-300 rounded text-sm"
              maxLength={5}
            />
            <input
              type="text"
              placeholder="CVC"
              value={cardData.cvc}
              onChange={(e) => setCardData({ ...cardData, cvc: e.target.value })}
              className="px-3 py-2 border border-gray-300 rounded text-sm"
              maxLength={4}
            />
          </div>
        </div>
      )}

      {/* Google Pay test info */}
      {paymentMethod === 'google' && (
        <div className="space-y-3 p-4 bg-stone-900/85 rounded-lg">
          <p className="text-sm tracking-tight text-white/75 font-medium uppercase">Google Pay Test Mode</p>
          <p className="text-xs text-white/75">
            Click the Pay button to simulate a Google Pay transaction in test mode.
          </p>
        </div>
      )}

      {/* Apple Pay test info */}
      {paymentMethod === 'apple' && (
        <div className="space-y-3 p-4 bg-stone-900/85 rounded-lg">
          <p className="text-sm tracking-tight text-white/75 font-medium uppercase">Apple Pay Test Mode</p>
          <p className="text-xs text-white/75">
            Click the Pay button to simulate an Apple Pay transaction in test mode.
          </p>
        </div>
      )}

      {/* Order Summary Section */}
        <div className="pt-4 tracking-tight">
          <div className="max-w-lg mx-auto space-y-3 pb-4 px-4">
          <h2 className="text-base tracking-tight mt-4 border-accent/10 border-b-2 font-semibold text-primary/75 mb-2 uppercase">Order Summary</h2>
            <p className="border-gray-500/10 border-b-2 border-dotted rounded-md flex justify-between text-sm">
              <span className="text-primary/85">Subtotal</span>
              <span className="text-primary/85">${cartTotal.toFixed(2)}</span>
            </p>
            <p className="border-gray-500/10 border-b-2 border-dotted rounded-md flex justify-between text-sm !mt-[-2]">
              <span className="text-primary/85">Tax (8%)</span>
              <span className="text-primary/85">${taxAmount.toFixed(2)}</span>
            </p>
            <p className="border-gray-500/10 border-b-2 border-dotted rounded-md flex justify-between text-sm !mt-[-2]">
              <span className="text-primary/85">Shipping</span>
              <span className="text-primary/85">$0.00</span>
            </p>
          </div>
          <div className="mb-10 mt-2 max-w-lg mx-auto border-gray-500/10 border-t-2 border-b-2 rounded-sm flex justify-between font-bold text-lg px-4">
            <span className="text-primary/85 !tracking-tight">Total</span>
            <span className="text-primary !tracking-tight">${grandTotal.toFixed(2)}</span>
          </div>
        </div>

      {/* Submit button */}
      <button
        onClick={handleTestPayment}
        disabled={isProcessing}
        className="btn-tertiary w-full py-3 text-lg font-semibold rounded-lg"
      >
        {isProcessing ? 'Processing...' : `Pay $${total.toFixed(2)}`}
      </button>

      {/* Google Pay Modal */}
      {showGooglePayModal && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
          <div className="bg-white rounded-lg shadow-lg max-w-md w-full">
            <div className="p-6 border-b border-gray-200">
              <h2 className="text-xl font-bold text-gray-900">Google Pay</h2>
            </div>
            <div className="p-6 space-y-4">
              <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p className="text-sm font-semibold text-gray-900 mb-2">Payment Details</p>
                <div className="space-y-2 text-sm text-gray-700">
                  <p className="flex justify-between">
                    <span>Subtotal:</span>
                    <span>${cartTotal.toFixed(2)}</span>
                  </p>
                  <p className="flex justify-between">
                    <span>Tax (8%):</span>
                    <span>${taxAmount.toFixed(2)}</span>
                  </p>
                  <p className="flex justify-between font-bold text-base border-t pt-2 mt-2">
                    <span>Total:</span>
                    <span>${grandTotal.toFixed(2)}</span>
                  </p>
                </div>
              </div>
              <div className="bg-blue-100 rounded-lg p-4 text-center">
                <p className="text-sm text-blue-900">•••• •••• •••• 4532</p>
                <p className="text-xs text-blue-800 mt-1">Google Account</p>
              </div>
            </div>
            <div className="p-6 border-t border-gray-200 flex gap-3">
              <button
                onClick={() => setShowGooglePayModal(false)}
                className="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                onClick={handleDigitalWalletConfirm}
                disabled={isProcessing}
                className="flex-1 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50"
              >
                {isProcessing ? 'Processing...' : 'Confirm Payment'}
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Apple Pay Modal */}
      {showApplePayModal && (
        <div className="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
          <div className="bg-white rounded-lg shadow-lg max-w-md w-full">
            <div className="p-6 border-b border-gray-200">
              <h2 className="text-xl font-bold text-gray-900">Apple Pay</h2>
            </div>
            <div className="p-6 space-y-4">
              <div className="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p className="text-sm font-semibold text-gray-900 mb-2">Payment Details</p>
                <div className="space-y-2 text-sm text-gray-700">
                  <p className="flex justify-between">
                    <span>Subtotal:</span>
                    <span>${cartTotal.toFixed(2)}</span>
                  </p>
                  <p className="flex justify-between">
                    <span>Tax (8%):</span>
                    <span>${taxAmount.toFixed(2)}</span>
                  </p>
                  <p className="flex justify-between font-bold text-base border-t pt-2 mt-2">
                    <span>Total:</span>
                    <span>${grandTotal.toFixed(2)}</span>
                  </p>
                </div>
              </div>
              <div className="bg-black rounded-lg p-4 text-center">
                <p className="text-sm text-white font-semibold">••••••••••••••1234</p>
                <p className="text-xs text-gray-300 mt-1">Apple Card</p>
              </div>
            </div>
            <div className="p-6 border-t border-gray-200 flex gap-3">
              <button
                onClick={() => setShowApplePayModal(false)}
                className="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors"
              >
                Cancel
              </button>
              <button
                onClick={handleDigitalWalletConfirm}
                disabled={isProcessing}
                className="flex-1 px-4 py-2 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition-colors disabled:opacity-50"
              >
                {isProcessing ? 'Processing...' : 'Confirm Payment'}
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}
