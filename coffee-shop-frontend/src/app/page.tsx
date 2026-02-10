import Link from 'next/link'
import { getFeaturedProducts, getFeaturedMenuItems } from '@/lib/wordpress'
import { ProductCard } from '@/components/ProductCard'

export default async function Home() {
  const featuredProducts = await getFeaturedProducts()
  const featuredMenuItems = await getFeaturedMenuItems()

  return (
    <>
      {/* Featured Products */}
      {featuredProducts.length > 0 && (
        <section className="section border-[#9a8d7e] md:border-t-2">
          <div className="container-custom">
            <div className="text-center mb-8">
              <h1 className="text-5xl max-w-xl font-extrabold md:font-bold text-white/75 uppercase tracking-tighter leading-10 max-w-max mx-auto px-2 mb-2">
                Curated Coffees from Around the World
              </h1>
              <p className="text-sm xl:text-base text-primary/70 max-w-xl mx-auto border-t-2 border-primary-dark/10 pt-1">
                Hand-selected by our master roasters, each bean reflects its origin, craft, and character.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
              {featuredProducts.map((product) => (
                <ProductCard
                  key={product.id}
                  id={product.id}
                  slug={product.slug}
                  title={product.title.rendered}
                  price={product.meta?.price || 0}
                  imageUrl={product.featured_image_url?.medium}
                  imageAlt={product.title.rendered}
                  roastLevel={product.meta?.roast_level}
                  origin={product.meta?.origin}
                />
              ))}
            </div>

            <div className="text-center mt-12 mb-4">
              <Link href="/products" className="btn btn-primary">
                View All Coffee
              </Link>
            </div>
          </div>
        </section>
      )}

      {/* About Section */}
      <section className="section bg-accent">
        <div className="container-custom">
          <div className="grid md:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-4xl font-bold text-white/85 mb-3">
                Our Commitment to Quality
              </h2>
              <p className="text-md text-white/75 mb-4 border-primary-light/20 border-t-2 pt-3">
                Every bean is carefully selected from sustainable farms around the world.
                We work directly with farmers to ensure fair prices and exceptional quality.
              </p>
              <p className="text-md text-white/75 mb-12">
                Our expert roasters bring out the unique characteristics of each origin,
                creating coffees that are both distinctive and delicious.
              </p>
              <Link href="/about" className="btn btn-secondary">
                Learn More About Us
              </Link>
            </div>
            <div className="aspect-[16/9] rounded-lg overflow-hidden">
              <img
                src="/quality-coffee.png"
                alt="Our commitment to quality - freshly roasted coffee beans"
                className="w-full h-full object-cover"
              />
            </div>
          </div>
        </div>
      </section>

      {/* Menu Preview */}
      {featuredMenuItems.length > 0 && (
        <section className="section">
          <div className="container-custom">
            <div className="text-center mb-12">
              <h2 className="text-4xl max-w-xl font-extrabold md:font-bold text-white/75 uppercase tracking-tighter leading-8 max-w-max mx-auto px-2 mb-2">
                Order Online from our Café
              </h2>
              <p className="text-sm xl:text-base text-primary/70 max-w-max mx-auto border-t-2 border-primary-dark/10 pt-1">
                Enjoy café-quality coffee and food with the convenience of online ordering, prepared fresh for pickup.
              </p>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-5 gap-4">
              {featuredMenuItems.map((item) => (
                <ProductCard
                  key={item.id}
                  id={item.id}
                  slug={item.slug}
                  title={item.title.rendered}
                  price={item.meta?.price || 0}
                  imageUrl={item.featured_image_url?.medium}
                  imageAlt={item.title.rendered}
                  category={item.meta?.category}
                  excerpt={item.excerpt.rendered}
                />
              ))}
            </div>

            <div className="flex-buttons mt-12">
              <Link href="/menu" className="btn btn-primary">
                View Full Menu
              </Link>
              <Link href="/locations" className="btn btn-primary">
                Find a Location
              </Link>
            </div>
          </div>
        </section>
      )}

      {/* CTA Section
      <section className="section bg-secondary">
        <div className="container-custom text-center">
          <h2 className="text-4xl font-bold text-primary mb-6">
            Visit Us Today
          </h2>
          <p className="text-lg text-primary-dark mb-8 max-w-2xl mx-auto">
            Experience the perfect cup at one of our café locations. Our baristas are ready to craft your favorite drink.
          </p>
          <Link href="/locations" className="btn btn-primary">
            Find a Location
          </Link>
        </div>
      </section> */}
    </>
  )
}
