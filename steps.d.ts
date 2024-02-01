/// <reference types='codeceptjs' />
type steps_file = typeof import('./steps_file');
type Default = typeof import('./tests/JS/pages/default');
type SimpleFormPage = typeof import('./tests/JS/pages/SimpleForm');

declare namespace CodeceptJS {
  interface SupportObject { I: I, current: any, SimpleFormPage: SimpleFormPage<Default>}
  interface Methods extends Playwright {}
  interface I extends ReturnType<steps_file> {}
  namespace Translation {
    interface Actions {}
  }
}
