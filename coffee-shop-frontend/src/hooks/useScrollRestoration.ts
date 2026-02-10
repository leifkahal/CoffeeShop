'use client'

import { useEffect, useRef } from 'react'
import { usePathname } from 'next/navigation'

export function useScrollRestoration() {
  const pathname = usePathname()
  const scrollPositions = useRef<Record<string, number>>({})
  const isBackNavigation = useRef(false)

  useEffect(() => {
    // Handle scroll restoration
    if (isBackNavigation.current && scrollPositions.current[pathname]) {
      // Restore scroll position for backward navigation
      window.scrollTo(0, scrollPositions.current[pathname])
      isBackNavigation.current = false
    } else {
      // Scroll to top for forward navigation
      window.scrollTo(0, 0)
    }
  }, [pathname])

  useEffect(() => {
    // Save scroll position when leaving a page
    const handleBeforeUnload = () => {
      scrollPositions.current[pathname] = window.scrollY
    }

    // Track navigation direction using popstate event
    const handlePopState = () => {
      isBackNavigation.current = true
    }

    window.addEventListener('beforeunload', handleBeforeUnload)
    window.addEventListener('popstate', handlePopState)

    return () => {
      window.removeEventListener('beforeunload', handleBeforeUnload)
      window.removeEventListener('popstate', handlePopState)
    }
  }, [pathname])
}
