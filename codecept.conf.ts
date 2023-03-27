import { setHeadlessWhen, setCommonPlugins } from '@codeceptjs/configure';
// turn on headless mode when running with HEADLESS=true environment variable
// export HEADLESS=true && npx codeceptjs run
setHeadlessWhen(process.env.HEADLESS);

// enable all common plugins https://github.com/codeceptjs/configure#setcommonplugins
setCommonPlugins();

export const config: CodeceptJS.MainConfig = {
  tests: './tests/JS/*_test.js',
  output: './tests/JS/output',
  helpers: {
    Playwright: {
      url: 'https://movistarco.local:8890',
      show: true,
      browser: 'chromium'
    }
  },
  plugins: {
    customLocator: {
      enabled: true
    }
  },
  include: {
    "formC2CPage": "./tests/JS/pages/form_c2c.ts",
  },
  name: 'movistar'
}