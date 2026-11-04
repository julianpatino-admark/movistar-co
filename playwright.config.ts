import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: './tests/e2e',
  fullyParallel: false,
  forbidOnly: !!process.env.CI,
  retries: process.env.CI ? 2 : 0,
  // El servidor local (BrowserSync + PHP) no soporta bien la ejecución en paralelo
  workers: 1,
  reporter: [['list']],
  use: {
    ignoreHTTPSErrors: true,
    baseURL: process.env.E2E_BASE_URL || 'http://localhost:3000/',
    trace: 'on-first-retry',
  },
  projects: [
    {
      name: 'chromium',
      use: { ...devices['Desktop Chrome'], channel: 'chrome' },
    },
  ],
});
