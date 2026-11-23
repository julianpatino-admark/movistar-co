import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import istanbul from 'vite-plugin-istanbul';
import path from 'path';

const inputFiles = [
  'resources/sass/generica.scss',
  'resources/sass/movil.scss',
  'resources/js/movil.js',
  'resources/sass/internet-movil.scss',
  'resources/js/internet-movil.js',
  'resources/sass/hogar.scss',
  'resources/js/hogar.js',
];

export default defineConfig({
  plugins: [
    laravel({
      input: inputFiles,
      refresh: true,
    }),
    istanbul({
        include: ['resources/js/**/*'],
        exclude: ['node_modules', 'tests/'],
        extension: ['.js', '.ts', '.vue'],
        requireEnv: true
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
    minify: 'esbuild',
    sourcemap: false,
  },
  server: {
    host: 'localhost'
  }
});
