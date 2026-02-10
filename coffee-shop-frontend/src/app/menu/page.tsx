import { getMenuByCategory } from '@/lib/wordpress'
import ClientMenuPage from '@/components/ClientMenuPage'

export const metadata = {
  title: 'Menu | CoffeeShop',
  description: 'Explore our café menu with hot drinks, cold drinks, and food options.',
}

export default async function MenuPage() {
  const menu = await getMenuByCategory()

  return <ClientMenuPage menu={menu} />
}
