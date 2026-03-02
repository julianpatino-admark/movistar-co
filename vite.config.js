import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';
import path from 'path';

const versions = ["generica", "movil", "internet-movil"]

const inputFiles = [];

versions.forEach(version => {
  inputFiles.push(`resources/sass/${version}.scss`);
  inputFiles.push(`resources/js/${version}.js`);
});

export default defineConfig({
  plugins: [
    laravel({
      input: inputFiles,
      refresh: [
        'resources/views/**',
        'resources/views/**',
        'resources/sass/**'
      ],
    }),
  ],
  resolve: {
      alias: {
        '$': 'jQuery',
        '@': '/resources/js',
        '@img': path.resolve(__dirname, 'resources/img'),
      },
  },
  build: {
    minify: 'esbuild'
  },
  server: {
    host: 'localhost'
  }
});