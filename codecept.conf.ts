import { setHeadlessWhen, setCommonPlugins } from '@codeceptjs/configure';
// turn on headless mode when running with HEADLESS=true environment variable
// export HEADLESS=true && npx codeceptjs run
setHeadlessWhen(process.env.HEADLESS);

// enable all common plugins https://github.com/codeceptjs/configure#setcommonplugins
setCommonPlugins();

export const config: CodeceptJS.MainConfig = {
  tests: 'tests/JS/*_test.ts',
  output: 'tests/JS/output',
  helpers: {
    Playwright: {
      browser: 'chromium',
      url: 'https://movistarco.test',
      show: true
    }
  },
  plugins: {
    customLocator: {
      enabled: true
    }
  },
  include: {
    I: './steps_file',
    SimpleFormPage: './tests/JS/pages/SimpleForm',
  },
  name: 'movistar'
}