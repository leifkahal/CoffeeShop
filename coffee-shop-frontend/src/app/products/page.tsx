import { getProducts } from '@/lib/wordpress'
import { ProductCard } from '@/components/ProductCard'

export const metadata = {
  title: 'Coffee Products | CoffeeShop',
  description: 'Browse our selection of premium coffee beans from around the world.',
}

export default async function ProductsPage() {
  const products = await getProducts()

  return (
    <section className="section min-h-screen">
      {/* Header */}
      <div className="text-center mb-12 max-sm:px-4">
              <h1 className="max-sm:text-4xl text-5xl max-w-xl font-extrabold md:font-bold text-white/75 uppercase tracking-tighter max-sm:!leading-8 leading-10 max-w-max mx-auto px-2 mb-2">
                World-Class Coffee, Thoughtfully Curated
              </h1>
              <p className="text-sm xl:text-base text-primary/70 max-w-xl mx-auto border-t-2 border-primary-dark/10 pt-1">
                Our master roasters choose each bean for its unique story, flavor, and origin.
              </p>
            </div>
      {/* Products Grid */}
      <section className="bg-background">
        <div className="container-custom">
          <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            {products.map((product) => (
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

          {products.length === 0 && (
            <div className="text-center py-16">
              <p className="text-xl text-primary/75">No products available at the moment.</p>
            </div>
          )}
        </div>
      {/* <section className="bg-accent text-white/85 py-16 pl-4 mt-12">
      <div className="container-custom">
        <h1 className="text-4xl font-bold mb-4">A Gift Worth Brewing</h1>
        <p className="text-xl text-gray-200 max-w-2xl">
Carefully curated coffees that make a refined, memorable gift for any coffee lover.
        </p>
        </div>
        </section> */}
      </section>
    </section>
  )
}

