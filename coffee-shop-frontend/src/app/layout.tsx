import type { Metadata } from 'next'
import './globals.css'
import LayoutContent from '@/components/layout/LayoutContent'

export const metadata: Metadata = {
  title: 'CoffeeShop - Artisan Coffee',
  description: 'Premium coffee beans and exceptional drinks. Visit our cafes or shop online.',
  icons: {
    icon: '/double.png',
  },
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="en">
      <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
      </head>
      <body>
        <LayoutContent>
          {children}
        </LayoutContent>
      </body>
    </html>
  )
}
