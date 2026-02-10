'use client'

import Image from 'next/image'
import { formatPrice } from '@/lib/wordpress'
import { MenuItemControls } from './MenuItemControls'
import { useCart } from '@/context/CartContext'

interface MenuItem {
  id: number
  title: { rendered: string }
  image?: string
  content?: { rendered: string }
  meta?: { price?: number; allergens?: string }
}

interface ClientMenuPageProps {
  menu: {
    hot: MenuItem[]
    cold: MenuItem[]
    food: MenuItem[]
  }
}

export default function ClientMenuPage({ menu }: ClientMenuPageProps) {
  const { addToCart, updateQuantity, removeFromCart } = useCart()

  const handleAddToCart = (id: number, title: string, quantity: number, price: number, image?: string, description?: string) => {
    addToCart(id, title, quantity, price, image, description)
  }

  const handleQuantityChange = (id: number, quantity: number) => {
    updateQuantity(id, quantity)
  }

  const handleRemove = (id: number) => {
    removeFromCart(id)
  }

  const renderMenuSection = (items: MenuItem[], title: string, description: string, isDark: boolean) => {
    if (items.length === 0) return null

    return (
      <section className={`section ${isDark ? 'section_dark bg-accent' : ''}`}>
        <div className="container-custom">
          <h2 className={`text-3xl font-bold uppercase mb-1 text-center ${isDark ? 'text-white/85' : 'text-white/85'}`}>
            {title}
          </h2>
          <p className={`text-sm text-center max-w-xl mx-auto border-t-2 pt-2 mb-8 ${isDark ? 'text-gray-300/75 border-secondary/10' : 'text-primary/70 border-accent/10'}`}>
            {description}
          </p>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {items.map((item) => (
              <div key={item.id} className="card flex flex-col">
                <div className="flex overflow-hidden flex-1">
                  <div className="relative w-32 shrink-0">
                    {item.image ? (
                      <Image src={item.image} alt={item.title.rendered} fill className="object-cover" />
                    ) : (
                      <div className="w-full h-full bg-primary/10 flex items-center justify-center">
                        <svg className="w-10 h-10 text-primary/30" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M2 21V19H20V21H2ZM20 8V5H22V8C22 9.1 21.1 10 20 10V8ZM18 3H4V14C4 15.1 4.9 16 6 16H16C17.1 16 18 15.1 18 14V3ZM6 1H18C18 1 20 1 20 3H2C2 1 4 1 6 1Z" />
                        </svg>
                      </div>
                    )}
                  </div>
                  <div className="px-4 pt-4 flex-1 flex flex-col">
                    <div className="flex items-start justify-between mb-1">
                      <h3 className="font-xs font-semibold text-primary/70 border-b-2 border-accent/10 pb-1 uppercase leading-none tracking-tighter">
                        {item.title.rendered}
                      </h3>
                      <span className="shadow-primary/10 shadow-lg bg-[#4A3231]/75 min-w-14 right-[-15] relative text-sm text-white/85 font-semibold pl-1 py-1 rounded-sm leading-none">
                        {formatPrice(item.meta?.price || 0)}
                      </span>
                    </div>
                    <div
                      className="text-primary/75 text-sm mb-3 tracking-tight"
                      dangerouslySetInnerHTML={{ __html: item.content?.rendered || '' }}
                    />
                    <p className="text-sm text-gray-500 flex-1">
                      Allergens: {item.meta?.allergens || 'None'}
                    </p>
                    <MenuItemControls
                      id={item.id}
                      title={item.title.rendered}
                      price={item.meta?.price || 0}
                      image={item.image}
                      description={item.content?.rendered}
                      onAddToCart={handleAddToCart}
                      onQuantityChange={handleQuantityChange}
                      onRemove={handleRemove}
                    />
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    )
  }

  return (
    <div className="min-h-screen">
      {renderMenuSection(
        menu.hot,
        'Hot Coffee & Tea',
        'Crafted with freshly brewed espresso and premium teas, our hot drinks are rich, smooth, and comforting. Every cup is made to warm you up and keep you going.',
        false
      )}
      {renderMenuSection(
        menu.cold,
        'Iced & Cold Brew',
        'Refreshing, smooth, and perfectly chilled. Our cold drinks feature iced coffee, cold brew, and specialty beverages blended for bold flavor and cool satisfaction—perfect any time of day.',
        true
      )}
      {renderMenuSection(
        menu.food,
        'From the Kitchen',
        'Crafted with freshly brewed espresso and premium teas, our hot drinks are rich, smooth, and comforting. From classic lattes to bold black coffee, every cup is made to warm you up and keep you going.',
        false
      )}
    </div>
  )
}
