'use client'

import Image from 'next/image'
import Link from 'next/link'
import { useState, useEffect, useRef } from 'react'
import { usePathname } from 'next/navigation'
import { useCart } from '@/context/CartContext'

export default function Header() {
  const pathname = usePathname()
  const { cartCount } = useCart()
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
  const [visible, setVisible] = useState(true)
  const lastScrollY = useRef(0)

  const isActive = (href: string) => {
    if (href === '/') {
      return pathname === '/'
    }
    return pathname.startsWith(href)
  }

  useEffect(() => {
    const handleScroll = () => {
      // Don't hide header when mobile menu is open
      if (mobileMenuOpen) return

      const currentScrollY = window.scrollY

      if (currentScrollY < 110) {
        setVisible(true)
      } else if (currentScrollY > lastScrollY.current) {
        setVisible(false)
      } else {
        setVisible(true)
      }

      lastScrollY.current = currentScrollY
    }

    window.addEventListener('scroll', handleScroll, { passive: true })
    return () => window.removeEventListener('scroll', handleScroll)
  }, [mobileMenuOpen])

  return (
    <header id="nav" className={`sticky top-0 z-50 bg-cream/95 border-b-4 border-[#9a8d7e] bg-hero-texture bg-blend-multiply bg-center px-2 transition-transform duration-300 ${visible ? 'translate-y-0' : '-translate-y-full'}`}>
      <div className="container mx-auto px-4 mt-0">
        {/* Desktop Header */}
        <div className="flex flex-col items-center pt-0 pb-0">

          {/* Mobile Header - 3-column grid for hard-centered logo */}
          <div className="md:hidden grid grid-cols-[1fr_auto_1fr] items-center py-2 w-full">
            {/* Left - Hamburger */}
            <button
              className="justify-self-start text-texta"
              aria-label="Toggle menu"
              onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
            >
              {mobileMenuOpen ? (
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                </svg>
              ) : (
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              )}
            </button>

            {/* Center - Logo */}
            <Link href="/" className="justify-self-center transition-none">
              <Image src="/double.png" alt="CoffeeShop" width={85} height={85} className="pb-1"/>
            </Link>

            {/* Right - Cart & Profile */}
            <div className="justify-self-end flex items-center space-x-2">
              <Link href="/account" className="text-texta hover:text-gold transition-colors rounded-full bg-white/15 p-1" aria-label="Profile">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </Link>
              <Link href="/cart" className="text-texta hover:text-gold transition-colors relative rounded-full bg-white/15 p-[3px]" aria-label="Cart">
                <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                </svg>
                {cartCount > 0 && (
                  <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    {cartCount}
                  </span>
                )}
              </Link>
            </div>
          </div>

          {/* Desktop Navigation - 3-column grid for hard-centered logo */}
          <nav className="hidden md:grid grid-cols-5 items-center rounded-lg">
            {/* Left links */}
            <div className="flex items-center justify-end max-lg:space-x-4 space-x-6 col-span-2">
              <Link
                href="/"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/') ? 'active-link' : ''}`}
              >
                Home
              </Link>
              <Link
                href="/menu"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/menu') ? 'active-link' : ''}`}
              >
                Cafe Order
              </Link>
              <Link
                href="/locations"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/locations') ? 'active-link' : ''}`}
              >
                Locations
              </Link>
            </div>

            {/* Logo - Hard centered */}
            <Link href="/" className="justify-self-center transition-none">
              <Image src="/double.png" alt="CoffeeShop" width={120} height={120} className="p-3" />
            </Link>

            {/* Right links */}
            <div className="flex items-center justify-start max-lg:space-x-4 space-x-6 col-span-2">
              <Link
                href="/products"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/products') ? 'active-link' : ''}`}
              >
                Buy Beans
              </Link>
              <Link
                href="/about"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/about') ? 'active-link' : ''}`}
              >
                About
              </Link>
              <Link
                href="/contact"
                className={`text-lg uppercase text-primary/70 min-w-max transition-colors duration-300 font-bold mx-2 focus-visible:outline-none ${isActive('/contact') ? 'active-link' : ''}`}
              >
                Contact
              </Link>
              {/* Cart & Profile Icons */}
              <div className="flex items-center space-x-4 pl-4 ml-4">
                <Link href="/account" className="text-texta hover:text-gold transition-colors rounded-full bg-white/20 p-1" aria-label="Profile">
                  <svg className="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </Link>
                <Link href="/cart" className="text-texta hover:text-gold transition-colors relative rounded-full bg-white/20 p-1" aria-label="Cart">
                  <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z" />
                  </svg>
                  {cartCount > 0 && (
                    <span className="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                      {cartCount}
                    </span>
                  )}
                </Link>
              </div>
            </div>
          </nav>

        </div>

        {/* Mobile Menu */}
        {mobileMenuOpen && (
          <nav className="md:hidden pb-6 md:border-t border-texta/10 pt-4">
            <div className="flex flex-col space-y-4">
              <Link
                href="/"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Home
              </Link>
              <Link
                href="/menu"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/menu') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Café Order
              </Link>
              <Link
                href="/locations"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/locations') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Locations
              </Link>
              <Link
                href="/products"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/products') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Buy Beans
              </Link>
              <Link
                href="/about"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/about') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                About
              </Link>
              <Link
                href="/contact"
                className={`text-lg uppercase tracking-tight text-primary/70 max-w-max transition-colors duration-300 font-black backdrop-blur-[2px] px-1 text-center focus-visible:outline-none mx-auto ${isActive('/contact') ? 'active-link' : ''}`}
                onClick={() => setMobileMenuOpen(false)}
              >
                Contact
              </Link>
            </div>
          </nav>
        )}

      </div>
    </header>
  )
}
