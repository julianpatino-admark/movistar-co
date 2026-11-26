import { defineConfig } from '@playwright/test';

// Keep browser fixtures and throttling counters away from application databases.
export default defineConfig({
  testDir: './tests/e2e',
  testMatch: 'monitor.spec.ts',
  workers: 1,
  fullyParallel: false,
  reporter: 'list',
  outputDir: '/tmp/movistar-monitor-browser-results',
  use: {
    baseURL: 'http://127.0.0.1:8091',
    trace: 'retain-on-failure',
    launchOptions: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH
      ? { executablePath: process.env.PLAYWRIGHT_CHROMIUM_EXECUTABLE_PATH }
      : {},
  },
  webServer: {
    command: 'mkdir -p /tmp/movistar-monitor-views && touch /tmp/movistar-monitor-browser.sqlite && php artisan migrate --force && php tests/fixtures/monitor.php && cd public && APP_ENV=local php -S 127.0.0.1:8091 -t . ../vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php',
    url: 'http://127.0.0.1:8091/monitor/login',
    reuseExistingServer: false,
    env: {
      APP_ENV: 'testing',
      APP_DEBUG: 'false',
      APP_KEY: 'base64:bW9uaXRvci1icm93c2VyLXRlc3RzLW9ubHktMTIzNDU=',
      APP_URL: 'http://127.0.0.1:8091',
      APP_CONFIG_CACHE: '/tmp/movistar-monitor-unused-config.php',
      APP_ROUTES_CACHE: '/tmp/movistar-monitor-unused-routes.php',
      DATABASE_URL: '',
      DB_CONNECTION: 'sqlite',
      DB_DATABASE: '/tmp/movistar-monitor-browser.sqlite',
      CACHE_DRIVER: 'array',
      MONITOR_CACHE_STORE: 'database',
      SESSION_DRIVER: 'file',
      SESSION_COOKIE: 'monitor_browser_test_session',
      SESSION_DOMAIN: '',
      SESSION_SECURE_COOKIE: 'false',
      MAIL_MAILER: 'array',
      MONITOR_PASSWORD_RESET_EMAIL_ENABLED: 'true',
      VIEW_COMPILED_PATH: '/tmp/movistar-monitor-views',
    },
  },
});
