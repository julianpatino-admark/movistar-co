const MODAL_ID = "modal-velocidades";
const FORM_ID = `${MODAL_ID}-form`;
const CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#thankyou_container";



const Utils = require("./utilities/main");

Feature("HOGAR - C2C VELOCIDAD")

BeforeSuite(({ I , formC2CPage}) => {
  formC2CPage.reinitialize();
  formC2CPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
})

Scenario("Modal - Validate that the value of the data and the title of each the modal match", async ({ I, formC2CPage }) => {

  /* "FIBRA 300 MB" */
  let btnValues = Object.values(Utils.velocidadesEnum);

  for (let i = 0; i < btnValues.length; i++) {

    I.click(formC2CPage.getC2cElementBtn(btnValues[i]));

    I.waitForVisible(CONTEXT);

    let dataTitleModal = await I.grabAttributeFrom(formC2CPage.getC2cElementBtn(btnValues[i]), 'data-modal-title');

    await within(CONTEXT, () => {
      I.seeTextEquals(dataTitleModal, ".modal_title");
      I.click("button.close");
    })
  }

})

Scenario("Modal - Visualization and valid initial errors on form", async ({ I, formC2CPage }) => {

  I.click(formC2CPage.getC2cElementBtn(Utils.velocidadesEnum.fibra_one));

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, () => {
    formC2CPage.sendFormMock(false);
    formC2CPage.validForm(true);
  })

})

Scenario("Modal 'Choose promos and plans'", async ({ I, formC2CPage }) => {
  /* "FIBRA + TELEFONÍA 300 MB" */
  I.click(formC2CPage.getC2cElementBtn(Utils.velocidadesEnum.fibra_two));

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, () => {
    formC2CPage.fillForm();
    formC2CPage.validForm(false);
    formC2CPage.sendFormMock();
  });

  I.wait(10);

  I.waitInUrl('/gracias');
  I.see("En breve te contactaremos para brindarte toda la información", CONTEXT_RESPONSE);
});