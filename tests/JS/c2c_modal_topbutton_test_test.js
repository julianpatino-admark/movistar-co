const MODAL_ID = "modal-c2c";
const FORM_ID = `${MODAL_ID}-form`;
const BASE_CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#modal-response";

Feature('HOGAR - C2C GENERIC');

BeforeSuite(({ I , formC2CPage}) => {
  formC2CPage.reinitialize();
  formC2CPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
})

Scenario("Modal 'Banner button we call you'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("PROMO MAIN BANNER"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'Choose a service (DirecTV, HBO Max, WinSports)'", async ({ I, formC2CPage }) => {
  I.click("$btn-oferta-hbomax");
  I.waitForVisible(BASE_CONTEXT);
  within(BASE_CONTEXT, () => {
    I.see("Te llamamos", ".modal-body")
    I.click("button.close");
  })

  I.click("$btn-oferta-winsports");
  I.waitForVisible(BASE_CONTEXT);
  within(BASE_CONTEXT, () => {
    I.see("Te llamamos", ".modal-body")
    I.click("button.close");
  })

  I.click("$btn-oferta-directv");
  I.waitForVisible(BASE_CONTEXT);
  await within(BASE_CONTEXT, async () => {
    I.see("Te llamamos", ".modal-body")
    
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'Help me choose banner'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("AYUDA ELEGIR"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'I just want telephony'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("TE LLAMAMOS Solo Telefonía"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'I want fiber only'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("TE LLAMAMOS Solo Fibra"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'I just want mobile only'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("TE LLAMAMOS Movil"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})

Scenario("Modal 'We call you only company'", async ({ I, formC2CPage }) => {
  I.click(formC2CPage.getC2cElementBtn("TE LLAMAMOS Empresa"));

  I.waitForVisible(BASE_CONTEXT);

  await within(BASE_CONTEXT, async () => {
    formC2CPage.fillForm();
    formC2CPage.validForm();
    formC2CPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})