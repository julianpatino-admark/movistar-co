import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import basicSsl from '@vitejs/plugin-basic-ssl';
import istanbul from 'vite-plugin-istanbul';
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