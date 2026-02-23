export {}
import { homeExtraListHogarEnum } from "./utilities/main";

const MODAL_ID = "modal-c2c";
const FORM_ID = `${MODAL_ID}-form`;
const BASE_CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#thankyou_container";

Feature('HOGAR - C2C GENERIC');

BeforeSuite(({ SimpleFormPage }) => {
  SimpleFormPage.reinitialize();
  SimpleFormPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
});

Scenario("Modal 'Banner button we call you'", async ({ I, SimpleFormPage }) => {
  I.click('$calcula-banner-btn');

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    SimpleFormPage.fillForm(true, {
      services: 'internet',
      contrata: 'si'
    });
    SimpleFormPage.validForm();
    SimpleFormPage.sendFormMock();
  });

  I.waitInUrl('/gracias');
  I.see("En breve te contactaremos para brindarte toda la información", CONTEXT_RESPONSE);
});

Scenario("Modal - Validate that the value of the data and the title of each the modal match", async ({ I, SimpleFormPage }) => {

  /* "FIBRA 300 MB" */
  let btnValues = Object.values(homeExtraListHogarEnum);

  for (let i = 1; i < btnValues.length; i++) {

    I.click(SimpleFormPage.getC2cElementBtn(btnValues[i]));

    I.waitForVisible(BASE_CONTEXT);

    await within(BASE_CONTEXT, async () => {
      I.seeInField('form input[type=hidden][name="c2c"]',btnValues[i]);
      I.click("button.close");
    });
  }

  I.click(SimpleFormPage.getC2cElementBtn(btnValues[0]));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    SimpleFormPage.fillForm(true, {
      services: 'internet',
      contrata: 'si'
    });
    SimpleFormPage.validForm();
    SimpleFormPage.sendFormMock();
  });

  I.waitInUrl('/gracias');
  I.see("En breve te contactaremos para brindarte toda la información", CONTEXT_RESPONSE);

});

