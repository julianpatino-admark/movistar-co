import { test, expect } from './fixtures';

for (const width of [360, 480, 1600]) {
    test(`formulario general conserva validación y campaña a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 900 });
        let submissions = 0;
        await page.route('**/api/form/send', route => {
            submissions++;
            return route.fulfill({ status: 200, json: { success: true } });
        });
        await page.goto('/internet-movil?tsource=0&utm_campaign=modals#registro');
        await page.locator('.splide__slide.is-active .total-hero__price').click();
        const modal = page.locator('#modal-c2c');
        const form = modal.locator('form');
        await expect(modal).toBeVisible();
        await expect(form.locator('[name="c2c"]')).not.toHaveValue('LLÁMAME GRATIS');
        await form.getByRole('button', { name: '¡Llámame!', exact: true }).click();
        await expect(form.locator('label.error:visible').first()).toBeVisible();
        expect(submissions).toBe(0);
        if (width === 1600) {
            await form.getByRole('link', { name: 'política de privacidad,' }).click();
            await expect(page.locator('#modal-text .modal_content')).toBeVisible();
            await expect(page.locator('#modal-text .modal_content')).not.toBeEmpty();
            await page.locator('#modal-text .close').click();
            await expect(page.locator('#modal-text')).toBeHidden();
            await expect(modal).toBeVisible();
        }
        await form.locator('[name="servicios"]').selectOption('internet');
        await form.locator('[name="phone"]').fill('3210000000');
        await form.locator('[name="name"]').fill('Prueba Modal');
        await form.locator('[name="legal"]').check();
        await form.getByRole('button', { name: '¡Llámame!', exact: true }).click();
        await expect(page).toHaveURL(/\/gracias\?tsource=0&utm_campaign=modals#registro$/);
        expect(submissions).toBe(1);
    });

    test(`retención aparece tras inactividad y registra a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 900 });
        await page.clock.install();
        await page.route('**/api/form/send', route => route.fulfill({ status: 200, json: { success: true } }));
        await page.goto('/movil?tsource=0&utm_campaign=retention');
        await page.clock.fastForward(21100);
        const modal = page.locator('#modal-retencion');
        await expect(modal).toBeVisible();
        await expect(modal.getByRole('heading', { name: '¡No te vayas!', exact: true })).toBeVisible();
        await expect(modal.locator('form')).toHaveAttribute('data-layer-page', '/c2c/retencion/conversion');
        await modal.locator('[name="servicios"]').selectOption('movil');
        await modal.locator('[name="phone"]').fill('3210000000');
        await modal.locator('[name="name"]').fill('Prueba Retención');
        await modal.locator('[name="legal"]').check();
        await modal.getByRole('button', { name: '¡Llámame!', exact: true }).click();
        await expect(page).toHaveURL(/\/gracias\?tsource=0&utm_campaign=retention$/);
    });
}

test('retención espera mientras el usuario usa otro diálogo y no reaparece al cerrarla', async ({ page }) => {
    await page.clock.install();
    await page.goto('/movil');
    await page.locator('.pospago-price').click();
    await expect(page.locator('#modal-c2c')).toBeVisible();
    await page.clock.fastForward(30000);
    await expect(page.locator('#modal-retencion')).toBeHidden();
    await page.locator('#modal-c2c .close').click();
    await expect(page.locator('#modal-c2c')).toBeHidden();
    await expect(page.locator('.modal-backdrop')).toHaveCount(0);
    await page.clock.fastForward(21100);
    await expect(page.locator('#modal-retencion')).toBeVisible();
    await page.locator('#modal-retencion .close').click();
    await expect(page.locator('#modal-retencion')).toBeHidden();
    await page.clock.fastForward(60000);
    await expect(page.locator('#modal-retencion')).toBeHidden();
});
