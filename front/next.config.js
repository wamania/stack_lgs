const isProd = process.env.NODE_ENV === "production";

// fix: prevents error when .less files are required by node
if (typeof require !== "undefined") {
  require.extensions[".less"] = (file) => {};
}

const nextConfig = {
  reactStrictMode: false,
  extends: [
    'plugin:@next/next/recommended',
  ],
}

module.exports = nextConfig
