import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins:[
      vue()
  ],
    server: {
        hmr: {
            host: 'localhost',
            port: 3000
        },
        watch: {
            usePolling: true
        },
        port: 3000
    },
    define: {
        global: 'window'
    },
})
