'use client'

import { useScrollRestoration } from '@/hooks/useScrollRestoration'
import { CartProvider } from '@/context/CartContext'
import Header from './Header'
import Footer from './Footer'

export default function LayoutContent({
  children,
}: {
  children: React.ReactNode
}) {
  useScrollRestoration()

  return (
    <CartProvider>
      <Header />
      <main className="min-h-screen">
        {children}
      </main>
      <Footer />
    </CartProvider>
  )
}
