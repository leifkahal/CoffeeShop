'use client'

interface ShareButtonProps {
  title: string
  address: string
}

export default function ShareButton({ title, address }: ShareButtonProps) {
  const handleShare = async () => {
    try {
      const hasShare = typeof navigator !== 'undefined' && typeof navigator.share === 'function'
      console.log('Has share API:', hasShare, 'Protocol:', window.location.protocol)

      if (hasShare) {
        try {
          await navigator.share({
            title: title,
            text: `Visit us at: ${address}`,
            url: window.location.href,
          })
          return
        } catch (shareError: unknown) {
          console.error('Share failed, trying clipboard:', shareError)
          // Fall through to clipboard
        }
      }

      // Fallback to clipboard
      if (navigator?.clipboard?.writeText) {
        try {
          await navigator.clipboard.writeText(address)
          alert('Address copied to clipboard!')
        } catch (clipboardError) {
          console.error('Clipboard copy failed:', clipboardError)
          alert('Unable to copy address')
        }
      } else {
        alert('Share not supported on this device')
      }
    } catch (error: unknown) {
      console.error('Unexpected error:', error)
      alert('Unable to share address')
    }
  }

  return (
    <button
      onClick={handleShare}
      className="inline-flex items-center gap-1 text-accent hover:text-accent/80 text-sm font-medium"
    >
      <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.06c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.44 9.31 6.77 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.77 0 1.44-.3 1.96-.77l7.12 4.16c-.04.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92 1.61 0 2.92-1.31 2.92-2.92s-1.31-2.92-2.92-2.92z"/>
      </svg>
      Share
    </button>
  )
}
