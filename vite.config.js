import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';

const versions = ["generica", "movil", "internet-movil"]

const inputFiles = [];

versions.forEach(version => {
  inputFiles.push(`resources/sass/${version}.scss`);
  inputFiles.push(`resources/js/${version}.js`);
});

export default defineConfig({
  plugins: [
    basicSsl(),
    laravel({
      input: inputFiles,
      refresh: [
        'resources/views/**'
      ],
    }),
  ],
  resolve: {
      alias: {
        '$': 'jQuery',
        '@': '/resources/js'
      },
  },
  build: {
    minify: 'esbuild'
  },
  server: {
    host: 'localhost'
  }
});