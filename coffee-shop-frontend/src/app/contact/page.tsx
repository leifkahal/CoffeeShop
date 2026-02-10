import { Metadata } from 'next'
import { getContactInfo } from '@/lib/wordpress'
import ContactForm from '@/components/ContactForm'

export const metadata: Metadata = {
  title: 'Contact Us | CoffeeShop',
  description: 'Get in touch with our team. We\'d love to hear from you.',
}

interface ContactInfoData {
  general_email?: string
  general_phone?: string
  support_email?: string
  support_phone?: string
  business_hours?: string
  address?: string
}

export default async function ContactPage() {
  const contactInfo = await getContactInfo() as ContactInfoData | null


  return (
    <div className="min-h-screen bg-background">
      {/* Hero Section */}
      <section className="bg-accent text-white/85 py-16">
        <div className="container-custom">
          <h1 className="text-4xl uppercase font-bold mb-4">Get in Touch</h1>
          <p className="text-xl text-gray-200 max-w-2xl">
            Have questions? We'd love to hear from you. Reach out to our team anytime.
          </p>
        </div>
      </section>

      {/* Contact Content */}
      <section className="section min-h-screen bg-background">
        <div className="container-custom">
          <div className="grid md:grid-cols-3 gap-12">
            {/* Contact Information */}
            <div className="md:col-span-1">
              <h2 className="text-2xl font-bold text-primary mb-8">Contact Information</h2>

              {/* General Contact */}
              <div className="mb-8 card p-6">
                <h3 className="form-heading mb-4 uppercase">General Inquiries</h3>
                {contactInfo?.general_email && (
                  <p className="text-primary/75 mb-2">
                    <span className="font-semibold text-primary">Email: </span>
                    <a
                      href={`mailto:${contactInfo.general_email}`}
                      className="hover:text-accent transition"
                    >
                      {contactInfo.general_email}
                    </a>
                  </p>
                )}
                {contactInfo?.general_phone && (
                  <p className="text-primary/75">
                    <span className="font-semibold text-primary">Phone: </span>
                    <a
                      href={`tel:${contactInfo.general_phone}`}
                      className="hover:text-accent transition"
                    >
                      {contactInfo.general_phone}
                    </a>
                  </p>
                )}
              </div>

              {/* Support */}
              <div className="mb-8 card p-6">
                <h3 className="form-heading mb-4 uppercase">Support</h3>
                {contactInfo?.support_email && (
                  <p className="text-primary/75 mb-2">
                    <span className="font-semibold text-primary">Email: </span>
                    <a
                      href={`mailto:${contactInfo.support_email}`}
                      className="hover:text-accent transition"
                    >
                      {contactInfo.support_email}
                    </a>
                  </p>
                )}
                {contactInfo?.support_phone && (
                  <p className="text-primary/75">
                    <span className="font-semibold text-primary">Phone: </span>
                    <a
                      href={`tel:${contactInfo.support_phone}`}
                      className="hover:text-accent transition"
                    >
                      {contactInfo.support_phone}
                    </a>
                  </p>
                )}
              </div>

              {/* Hours */}
              {contactInfo?.business_hours && (
                <div className="card p-6">
                  <h3 className="form-heading mb-4 uppercase">Business Hours</h3>
                  <pre className="text-primary/75 whitespace-pre-wrap font-sans text-sm">
                    {contactInfo.business_hours}
                  </pre>
                </div>
              )}

              {/* Address */}
              {contactInfo?.address && (
                <div className="mt-8 card p-6">
                  <h3 className="form-heading mb-4 uppercase">Address</h3>
                  <p className="text-primary/75">{contactInfo.address}</p>
                </div>
              )}
            </div>

            {/* Contact Form */}
            <div className="md:col-span-2">
              <ContactForm />
            </div>
          </div>
        </div>
      </section>
    </div>
  )
}
