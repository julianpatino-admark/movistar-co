import { test, expect, type Page } from '@playwright/test';

const email = 'operator@example.com';
const password = 'BrowserMonitor2026!';

async function login(page: Page) {
  await page.goto('/monitor/login');
  await page.getByLabel('Correo electrónico').fill(email);
  await page.getByLabel('Contraseña', { exact: true }).fill(password);
  await page.getByRole('button', { name: 'Iniciar sesión', exact: true }).click();
  await expect(page).toHaveURL(/\/monitor\/gocontact$/);
}

test('monitor authentication, filters, detail dialog, pagination and logout', async ({ page }) => {
  await page.goto('/monitor/gocontact');
  await expect(page).toHaveURL(/\/monitor\/login$/);
  await login(page);
  await expect(page.getByRole('heading', { name: 'Monitoreo de leads', exact: true })).toBeVisible();
  await expect(page.getByText('Mostrando', { exact: false })).toContainText('56');
  await page.getByRole('link', { name: 'Siguiente', exact: true }).click();
  await expect(page).toHaveURL(/page=2/);
  await page.getByRole('link', { name: 'Anterior', exact: true }).click();
  await page.locator('.detail-button').first().click();
  await expect(page.getByRole('dialog')).toBeVisible();
  await expect(page.getByRole('dialog')).toContainText('Request ID');
  await page.keyboard.press('Escape');
  await expect(page.getByRole('dialog')).not.toBeVisible();
  await page.getByLabel('Resultado', { exact: true }).selectOption('failed');
  await page.getByRole('button', { name: 'Aplicar filtros' }).click();
  await expect(page.locator('.attempts-table tbody tr')).toHaveCount(14);
  await expect(page.locator('.attempts-table .badge--success')).toHaveCount(0);
  await page.getByRole('link', { name: 'Mi cuenta', exact: true }).first().click();
  await expect(page.getByRole('heading', { name: 'Actualizar contraseña' })).toBeVisible();
  await page.getByRole('button', { name: 'Cerrar sesión', exact: true }).first().click();
  await expect(page).toHaveURL(/\/monitor\/login$/);
});

for (const width of [390, 820, 1600]) {
  test(`monitor and authentication layouts fit ${width}px`, async ({ page }) => {
    await page.setViewportSize({ width, height: 1000 });
    await page.goto('/monitor/login');
    await page.getByLabel('Contraseña', { exact: true }).fill('visible-test');
    await page.getByRole('button', { name: 'Mostrar contraseña', exact: true }).click();
    await expect(page.getByLabel('Contraseña', { exact: true })).toHaveAttribute('type', 'text');
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBeTruthy();
    await page.getByRole('link', { name: '¿Olvidaste tu contraseña?' }).click();
    await expect(page.getByRole('heading', { name: '¿Olvidaste tu contraseña?' })).toBeVisible();
    await expect(page.getByLabel('Correo de tu cuenta')).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBeTruthy();
    await page.goto('/monitor/reset-password/example-token?email=operator%40example.com');
    await expect(page.getByRole('heading', { name: 'Crea tu nueva contraseña' })).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBeTruthy();
    await login(page);
    await expect(page.locator('.metrics')).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBeTruthy();
    if (width < 701) {
      await page.getByLabel('Historial de envíos').evaluate((element) => { element.scrollLeft = element.scrollWidth; });
      await page.locator('.detail-button').first().click();
      await expect(page.getByRole('dialog')).toBeVisible();
      await page.keyboard.press('Escape');
      await page.locator('.mobile-menu > summary').click();
      await page.getByRole('link', { name: 'Mi cuenta', exact: true }).last().click();
    } else {
      await page.getByRole('link', { name: 'Mi cuenta', exact: true }).first().click();
    }
    await expect(page.getByRole('heading', { name: 'Actualizar contraseña' })).toBeVisible();
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= window.innerWidth)).toBeTruthy();
  });
}
