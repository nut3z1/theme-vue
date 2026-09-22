import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
  plugins: [vue()],
  
  build: {
    // Output to assets directory for WordPress
    outDir: 'assets',
    emptyOutDir: true,
    
    // Generate manifest for cache busting
    manifest: true,
    
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'src/main.js'),
      },
      output: {
        // Predictable filenames (no hash) for WordPress enqueue
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'images/[name]-[hash][extname]';
        },
      },
    },
  },
  
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
  
  // Dev server settings
  server: {
    port: 3000,
    // Proxy API calls to local WordPress
    proxy: {
      '/wp-json': {
        target: 'http://localhost:8080',
        changeOrigin: true,
      },
    },
  },
});
