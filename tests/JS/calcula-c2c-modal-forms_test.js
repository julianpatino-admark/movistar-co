const MODAL_ID = "modal-c2c-calcula";
const FORM_ID = `${MODAL_ID}-form`;
const CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#modal-response";

const Utilities = require("./utilities/main");

const slideNext = locate('a').withAttr({ "href" : "#carouselMainBanner", "data-slide": "next" });
const clienteNoClienteLabelError = `label#${FORM_ID}-select-clientenocliente-error`;

Feature("HOGAR - CALCULA")

BeforeSuite(({ I , formCalculaPage}) => {
  formCalculaPage.reinitialize();
  formCalculaPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
})

Scenario("Modal - Visualization and valid initial errors on form", async ({ I, formCalculaPage }) => {

  I.click(slideNext);

  I.click("$btn-calcula-banner");

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, () => {
    formCalculaPage.sendFormMock(false);
    formCalculaPage.validForm(true, {
      cliente: clienteNoClienteLabelError
    });
  })

})

Scenario("Modal 'Choose promos and plans'", async ({ I, formCalculaPage }) => {

  I.click(slideNext);

  I.click("$btn-calcula-banner");

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, async () => {
    formCalculaPage.fillForm();
    formCalculaPage.validForm(false, {
      cliente: clienteNoClienteLabelError
    });
    formCalculaPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Tu solicitud se ha enviado correctamente", CONTEXT_RESPONSE);
})


Scenario("Modal 'Check if the input mix-value concat the right data'", async ({ I, formCalculaPage }) => {

  I.click(slideNext);

  I.click("$btn-calcula-banner");

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, async () => {
    formCalculaPage.fillForm();
    I.seeInField("input[name='observations']", "fibra + telefonia+movil+No es cliente,");
    formCalculaPage.uncheckSomeOptions(['fibra']);
    I.seeInField("input[name='observations']", "movil+No es cliente, ");
  })
})
