const MODAL_ID = 'modal-cobertura';
const FORM_ID = `${MODAL_ID}-form`;
const CONTEXT = `#${MODAL_ID}.show`;
const CONTEXT_RESPONSE = "#modal-response-cobertura";

Feature("HOGAR - COBERTURA")

BeforeSuite(({ I , formCoberturaPage}) => {
  formCoberturaPage.reinitialize();
  formCoberturaPage.initFields(FORM_ID);
});

Before(({ I }) => {
  I.amOnPage("/");
})

Scenario("Modal - Visualization and valid initial errors on form", async ({ I, formCoberturaPage }) => {

  I.click('$btn-cobertura');

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, async () => {
    formCoberturaPage.sendFormMock(false);
    formCoberturaPage.validForm(true, {
      province: "#selectProvince-error",
      phone: "#userCoberturaCellPhone-error"
    });
  })

})

Scenario("Modal 'User has coverage'", async ({ I, formCoberturaPage }) => {

  I.click('$btn-cobertura');

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, async () => {
    await formCoberturaPage.fillWithTown();
    I.seeElement('select#selectTown');
    formCoberturaPage.validForm();
    formCoberturaPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("si tienes cobertura", CONTEXT_RESPONSE);
});

Scenario("Modal 'User has no coverage'", async ({ I, formCoberturaPage }) => {

  I.click('$btn-cobertura');

  I.waitForVisible(CONTEXT);

  await within(CONTEXT, async () => {
    await formCoberturaPage.fillWithoutTown();
    I.dontSeeElement('select#selectTown');
    formCoberturaPage.validForm();
    formCoberturaPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Malas noticias", CONTEXT_RESPONSE);
});

Scenario("Modal - No neighborhood checked ", async ({ I, formCoberturaPage }) => {

  I.click('$btn-cobertura');

  I.waitForVisible(CONTEXT);

  I.waitForVisible(`#${FORM_ID}`);
  await within(CONTEXT, async () => {
    await formCoberturaPage.checkNoNeighborhood();
    formCoberturaPage.validForm();
    formCoberturaPage.sendFormMock();
  })

  I.waitForVisible(CONTEXT_RESPONSE);
  I.see("Malas noticias", CONTEXT_RESPONSE);

});