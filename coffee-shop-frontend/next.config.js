/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'http',
        hostname: '192.168.0.118',
        port: '10023',
      },
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '10003',
      },
      {
        protocol: 'http',
        hostname: 'coffee-shop.local',
      },
    ],
  },
}

module.exports = nextConfig
