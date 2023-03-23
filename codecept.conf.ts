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
    I: './steps_file',
    "formCoberturaPage": "./tests/JS/pages/form_cobertura.ts",
    "formCalculaPage": "./tests/JS/pages/form_calcula.ts",
    "formC2CPage": "./tests/JS/pages/form_c2c.ts",
  },
  name: 'movistar'
}