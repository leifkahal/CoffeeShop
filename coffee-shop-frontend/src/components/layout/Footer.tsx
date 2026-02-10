import Link from 'next/link'
import Image from 'next/image'

// Add this to your layout's <head>:
// <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />

export default function Footer() {
  return (
    <footer>
      <div className="container-custom max-sm:pb-14 pt-10 pb-2 max-w-6xl">
        <div className="grid grid-cols-1 md:grid-cols-5 gap-12 text-center md:text-left">
          {/* Column 1: About */}
          <div className="md:col-span-2 mt-[-8] flex flex-col items-center md:items-start">
            <Image
              src="/double.png"
              alt="CoffeeShop Logo"
              width={90}
              height={45}
              className="mb-2 justify-self-center mx-auto"
              style={{ width: 'auto', height: '75px' }}
            />
            <p className="text-white/50 mb-4 text-sm text-center max-w-xs mx-auto max-w-max">
              Artisan coffee roasted with care. Serving exceptional coffee since 2024.
            </p>
          </div>

          {/* Column 2: Shop */}
          <div className="flex flex-col items-center md:items-start">
            <h4 className="font-bold mb-2 text-white/50 border-background/10 border-b-2 max-w-max">Shop</h4>
            <ul className="space-y-1">
              <li>
                <Link href="/products" className="text-white/50 hover:text-secondary transition-colors">
                  Coffee Beans
                </Link>
              </li>
              <li>
                <Link href="/menu" className="text-white/50 hover:text-secondary transition-colors">
                  Menu
                </Link>
              </li>
              <li>
                <Link href="/locations" className="text-white/50 hover:text-secondary transition-colors">
                  Locations
                </Link>
              </li>
            </ul>
          </div>

          {/* Column 3: Company */}
          <div className="flex flex-col items-center md:items-start">
            <h4 className="font-bold mb-2 text-white/50 border-background/10 border-b-2 max-w-max">Company</h4>
            <ul className="space-y-1">
              <li>
                <Link href="/about" className="text-white/50 hover:text-secondary transition-colors">
                  About Us
                </Link>
              </li>
              <li>
                <Link href="/about#team" className="text-white/50 hover:text-secondary transition-colors">
                  Our Team
                </Link>
              </li>
              <li>
                <Link href="/contact" className="text-white/50 hover:text-secondary transition-colors">
                  Contact
                </Link>
              </li>
            </ul>
          </div>

          {/* Column 4: Connect */}
          <div className="flex flex-col items-center md:items-start">
            <h4 className="font-bold mb-2 text-white/50 border-background/10 border-b-2 max-w-max">Connect</h4>
            <ul className="space-y-1">
              <li>
                <a
                  href="https://instagram.com"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-white/50 hover:text-secondary transition-colors"
                  aria-label="Instagram"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.266.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12c0-3.403 2.759-6.162 6.162-6.162 3.403 0 6.162 2.759 6.162 6.162 0 3.403-2.759 6.162-6.162 6.162-3.403 0-6.162-2.759-6.162-6.162zm2.889 0c0 1.821 1.472 3.293 3.273 3.293 1.821 0 3.293-1.472 3.293-3.293 0-1.821-1.472-3.293-3.293-3.293-1.801 0-3.273 1.472-3.273 3.293zm9.752-6.464c0 .795.645 1.44 1.44 1.44.795 0 1.44-.645 1.44-1.44-.001-.795-.645-1.44-1.44-1.44-.795 0-1.44.645-1.44 1.44z" />
                  </svg>
                  Instagram
                </a>
              </li>
              <li>
                <a
                  href="https://facebook.com"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-white/50 hover:text-secondary transition-colors"
                  aria-label="Facebook"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                  </svg>
                  Facebook
                </a>
              </li>
              <li>
                <a
                  href="https://youtube.com"
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-2 text-white/50 hover:text-secondary transition-colors"
                  aria-label="YouTube"
                >
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                  </svg>
                  YouTube
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t-4 border-background/10">
        <div className="container-custom py-6">
          <p className="text-center text-white/50 text-sm">
            © {new Date().getFullYear()} CoffeeShop. All rights reserved.
          </p>
        </div>
      </div>
    </footer>
  )
}
