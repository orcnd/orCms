import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
  plugins: [
    viteStaticCopy({
      targets: [
        {
          src: 'resources/views/templates/default/assets',
          dest: '',
        },
      ],
    }),
    laravel({
      input: ['resources/sass/app.scss', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
})
