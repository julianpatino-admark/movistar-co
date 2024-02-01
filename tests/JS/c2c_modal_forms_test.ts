export {}
import { velocidadesEnum } from "./utilities/main";

const MODAL_ID = "modal-velocidades";
const FORM_ID = `${MODAL_ID}-form`;
const CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#thankyou_container";

Feature("HOGAR - C2C VELOCIDAD")

BeforeSuite(({ SimpleFormPage }) => {
  SimpleFormPage.reinitialize();
  SimpleFormPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
})

Scenario("Modal - Validate that the value of the data and the title of each the modal match", async ({ I, SimpleFormPage }) => {

  /* "FIBRA 300 MB" */
  let btnValues = Object.values(velocidadesEnum);

  for (let i = 0; i < btnValues.length; i++) {

    I.click(SimpleFormPage.getC2cElementBtn(btnValues[i]));

    I.waitForVisible(CONTEXT);

    let dataTitleModal = await I.grabAttributeFrom(SimpleFormPage.getC2cElementBtn(btnValues[i]), 'data-modal-title');

    await within(CONTEXT, () => {
      I.seeTextEquals(dataTitleModal, ".modal_title");
      I.click("button.close");
    })
  }

})

Scenario("Modal - Visualization and valid initial errors on form", async ({ I, SimpleFormPage }) => {

  I.click(SimpleFormPage.getC2cElementBtn(velocidadesEnum.fibra_one));

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, () => {
    SimpleFormPage.sendFormMock(false);
    SimpleFormPage.validForm(true);
  })

})

Scenario("Modal 'Choose promos and plans'", async ({ I, SimpleFormPage }) => {
  /* "FIBRA + TELEFONÍA 300 MB" */
  I.click(SimpleFormPage.getC2cElementBtn(velocidadesEnum.fibra_two));

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, () => {
    SimpleFormPage.fillForm();
    SimpleFormPage.validForm(false);
    SimpleFormPage.sendFormMock();
  });

  I.wait(10);

  I.waitInUrl('/gracias');
  I.see("En breve te contactaremos para brindarte toda la información", CONTEXT_RESPONSE);
});