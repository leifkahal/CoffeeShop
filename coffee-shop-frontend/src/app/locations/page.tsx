import { getLocations } from '@/lib/wordpress'
import ShareButton from '@/components/ShareButton'

export const metadata = {
  title: 'Locations | CoffeeShop',
  description: 'Visit one of our café locations.',
}

export default async function LocationsPage() {
  const locations = await getLocations()

  return (
    <div className="min-h-screen">
      {/* Header */}
      {/* <section className="bg-accent text-white/85 py-16 pl-4">
        <div className="container-custom">
          <h1 className="text-4xl uppercase font-bold mb-4">Our Locations</h1>
          <p className="text-xl text-gray-200 max-w-2xl">
            Visit us at one of our welcoming café locations. Each offers a unique atmosphere
            and the same exceptional coffee.
          </p>
        </div>
      </section> */}

      {/* Locations */}
      <section className="section min-h-screen bg-background max-sm:pt-8 pt-16">
        <div className="container-custom">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {locations.map((location) => (
              <div key={location.id} className="card">
                <div className="p-8">
                  <h2 className="text-xl font-bold tracking-tight text-primary/75 border-b-2 border-accent/10 uppercase mb-1">
                    {location.title.rendered}
                  </h2>

                  <div
                    className="text-primary/75 mb-6 leading-none text-sm tracking-tight pt-1"
                    dangerouslySetInnerHTML={{ __html: location.content?.rendered || '' }}
                  />

                  <div className="space-y-3 text-sm">
                    {/* Address */}
                    {location.meta?.address_street && (
                      <div>
                        <h4 className="font-bold text-primary mb-1">Address</h4>
                        <p className="text-primary/75 mb-2">
                          {location.meta.address_street}<br />
                          {location.meta.address_city}, {location.meta.address_state} {location.meta.address_zip}
                        </p>
                        <div className="flex gap-2">
                          <a
                            href={`https://maps.google.com/?q=${encodeURIComponent(
                              `${location.meta.address_street} ${location.meta.address_city}, ${location.meta.address_state} ${location.meta.address_zip}`
                            )}`}
                            target="_blank"
                            rel="noopener noreferrer"
                            className="inline-flex items-center gap-1 text-accent hover:text-accent/80 text-sm font-medium"
                          >
                            <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5z"/>
                            </svg>
                            View on Maps
                          </a>
                          <ShareButton
                            title={location.title.rendered}
                            address={`${location.meta.address_street}, ${location.meta.address_city}, ${location.meta.address_state} ${location.meta.address_zip}`}
                          />
                        </div>
                      </div>
                    )}

                    {/* Contact */}
                    <div>
                      <h4 className="font-bold text-primary mb-1">Contact</h4>
                      {location.meta?.phone && (
                        <p className="text-primary/75">
                          <a href={`tel:${location.meta.phone}`} className="hover:text-accent">
                            {location.meta.phone}
                          </a>
                        </p>
                      )}
                      {location.meta?.email && (
                        <p className="text-primary/75">
                          <a href={`mailto:${location.meta.email}`} className="hover:text-accent">
                            {location.meta.email}
                          </a>
                        </p>
                      )}
                    </div>

                    {/* Hours */}
                    {location.meta?.hours && (
                      <div>
                        <h4 className="font-bold text-primary mb-1">Hours</h4>
                        <pre className="text-primary/75 whitespace-pre-wrap font-sans">
                          {location.meta.hours}
                        </pre>
                      </div>
                    )}
                  </div>
                </div>
              </div>
            ))}
          </div>

          {locations.length === 0 && (
            <div className="text-center py-16">
              <p className="text-xl text-primary/75">No locations available at the moment.</p>
            </div>
          )}
        </div>
      </section>
    </div>
  )
}
