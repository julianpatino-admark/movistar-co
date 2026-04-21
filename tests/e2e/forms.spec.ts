import { test, expect } from './fixtures';

import { MainFormComponent } from './pages/MainFormComponent';
import { FormularioData } from './utilities/interfaces';

test('has title', async ({ page }) => {
  await page.goto('');

  // Expect a title "to contain" a substring.
  await expect(page).toHaveTitle('Movistar Co | Planes de internet y telefonía para el hogar');
});

test.describe('Pruebas en el formulario principal', () => {
  let mainForm: MainFormComponent;

  let datosValidados:FormularioData = {
    nombre: "Pedrito Perez",
    telefono: "3210000000",
    servicios: "internet",
    aceptaTyc: true
  };

  test.beforeEach(async ({ page }) => {
    await page.goto('');

    // Esperamos a que el contenedor del formulario esté 100% interactivo
    await page.locator('#c2c-main').waitFor({ state: 'visible' });

    // Un pequeño respiro de medio segundo para que jQuery Validation se conecte
    await page.waitForTimeout(500);

    mainForm = new MainFormComponent(page, '#c2c-main');
  });

  test('debe mostrar errores de obligatoriedad si se envía vacío', async () => {
    await mainForm.submitBtn.click();

    await expect(mainForm.errorNombre).toHaveText(mainForm.expectedErrors.required);
    await expect(mainForm.errorNumero).toHaveText(mainForm.expectedErrors.required);
    await expect(mainForm.errorServicios).toHaveText(mainForm.expectedErrors.required);
    await expect(mainForm.errorTyc).toHaveText(mainForm.expectedErrors.required);

  });

  test('debe mostrar error al ingresar un teléfono inválido', async () => {  
    await mainForm.submitBtn.click();
    
    await mainForm.fillForm({ telefono: '3'});
    await expect(mainForm.errorNumero).toHaveText(mainForm.expectedErrors.invalidPhone);
  });


  test('debe ocultar los errores al llenar el formulario correctamente', async () => {
    await mainForm.submitBtn.click();
    await mainForm.fillForm(datosValidados);

    await expect(mainForm.errorNombre).toBeHidden();
    await expect(mainForm.errorNumero).toBeHidden();
    await expect(mainForm.errorTyc).toBeHidden();
  });

  test('valida que se envie el formulario correctamente', async ({ page }) => {
    mainForm.mockForm(200);
    await mainForm.fillForm(datosValidados);

    await mainForm.submitBtn.click();

    await page.waitForURL(/.*gracias/, { timeout: 15000 });

    await page.waitForLoadState('load');
    await expect(mainForm.tituloGracias).toBeVisible();
  });

  test('valida que se envie el formulario y responda duplicado', async ({ page }) => {
    mainForm.mockForm(422);
    await mainForm.fillForm(datosValidados);

    await mainForm.submitBtn.click();

    await expect(mainForm.modalResponseText).toBeVisible();
    await expect(mainForm.modalResponseText).toHaveText(mainForm.expectedErrors.duplicatedPhone);

    await expect(page).toHaveTitle('Movistar Co | Planes de internet y telefonía para el hogar');
  });
});
