import { NextRequest, NextResponse } from 'next/server'

export async function POST(request: NextRequest) {
  try {
    const body = await request.json()
    const { name, email, phone, subject, message } = body

    // Validate required fields
    if (!name || !email || !subject || !message) {
      return NextResponse.json(
        { error: 'Missing required fields' },
        { status: 400 }
      )
    }

    // Validate email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
    if (!emailRegex.test(email)) {
      return NextResponse.json(
        { error: 'Invalid email address' },
        { status: 400 }
      )
    }

    // Send to WordPress via REST API
    const wpApiUrl = process.env.NEXT_PUBLIC_WORDPRESS_API_URL || 'http://coffee-shop.local/wp-json'

    const contactPayload = {
      title: `Contact Form: ${subject}`,
      content: `
<p><strong>Name:</strong> ${name}</p>
<p><strong>Email:</strong> ${email}</p>
${phone ? `<p><strong>Phone:</strong> ${phone}</p>` : ''}
<p><strong>Subject:</strong> ${subject}</p>
<p><strong>Message:</strong></p>
<p>${message.replace(/\n/g, '<br>')}</p>
      `,
      status: 'publish',
      meta: {
        contact_name: name,
        contact_email: email,
        contact_phone: phone || '',
        contact_subject: subject,
      },
    }

    // Option 1: Save as WordPress post (requires custom post type or permissions)
    const wpResponse = await fetch(`${wpApiUrl}/wp/v2/posts`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${process.env.WORDPRESS_API_TOKEN || ''}`,
      },
      body: JSON.stringify(contactPayload),
    }).catch(() => null) // Fallback if no auth token

    // Option 2: Send email directly via WordPress
    const emailResponse = await fetch(`${wpApiUrl}/coffee-shop/v1/send-contact-email`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        from_name: name,
        from_email: email,
        phone,
        subject,
        message,
      }),
    }).catch(() => null)

    // If WordPress endpoints aren't available, use alternative service
    if (!wpResponse?.ok && !emailResponse?.ok) {
      // Fallback: Log to console in development
      if (process.env.NODE_ENV === 'development') {
        console.log('Contact form submission:', { name, email, phone, subject, message })
        return NextResponse.json(
          { success: true, message: 'Message received (dev mode)' },
          { status: 200 }
        )
      }

      // In production, you might want to use a service like Resend, SendGrid, etc.
      // For now, return an error
      return NextResponse.json(
        { error: 'Unable to send message. Please try again later.' },
        { status: 500 }
      )
    }

    return NextResponse.json(
      { success: true, message: 'Message sent successfully' },
      { status: 200 }
    )
  } catch (error) {
    console.error('Contact form error:', error)
    return NextResponse.json(
      { error: 'An error occurred while processing your request' },
      { status: 500 }
    )
  }
}
