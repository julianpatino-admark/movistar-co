import { test, expect } from './fixtures';

for (const width of [360, 480, 1600]) {
    test(`registro y confirmación responsive a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 1000 });
        let submissions = 0;
        await page.route('**/api/form/send', route => {
            submissions++;
            return route.fulfill({ status: 200, json: { success: true, message: 'Registro recibido' } });
        });
        await page.goto('/movil?tsource=0&utm_campaign=thankyou#registro');

        let form = page.locator('#c2c-movil-desktop');
        if (width < 1200) {
            await page.locator('#movil-offers .splide__slide.is-active .card-offer_cta button').click();
            form = page.locator('#c2c-velocidades');
        } else {
            await form.locator('[name="servicios"]').selectOption('movil');
        }
        await form.locator('[name="phone"]').fill('3210000000');
        await form.locator('[name="name"]').fill('Prueba Confirmación');
        await form.locator('[name="legal"]').check();
        await form.getByRole('button', { name: /Llámame/ }).click();

        await expect(page).toHaveURL(/\/gracias\?tsource=0&utm_campaign=thankyou#registro$/);
        await expect(page.getByRole('heading', { name: '¡GRACIAS!', exact: true })).toBeVisible();
        await expect(page.locator('[data-toggle="form-simple"]')).toHaveCount(0);
        await expect(page.locator('#modal-retencion')).toHaveCount(0);
        expect(submissions).toBe(1);

        await page.evaluate(() => document.fonts.ready);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBeTruthy();
        await expect(page.locator('.thankyou__numbers a')).toHaveText(['300 916 22 34', '300 917 66 10']);
        if (width < 1200) {
            await page.getByRole('button', { name: 'Abrir menú de servicios' }).click();
            await expect(page.locator('#navbarMobileCollapse')).toBeVisible();
            await expect(page.locator('#navbarMobileCollapse a[href="/movil?tsource=0&utm_campaign=thankyou"]')).toBeVisible();
            await expect(page.locator('#navbarMobileCollapse')).toHaveClass(/\bshow\b/);
            await page.getByRole('button', { name: 'Abrir menú de servicios' }).click();
            await expect(page.locator('#navbarMobileCollapse')).toBeHidden();
        } else {
            await expect(page.getByRole('link', { name: 'Volver al home' })).toHaveAttribute('href', /\?tsource=0&utm_campaign=thankyou$/);
        }

        await page.getByRole('button', { name: /Condiciones/ }).click();
        await expect(page.locator('#collapseOne')).toBeVisible();
        await expect(page.locator('#collapseOne')).toHaveClass(/\bshow\b/);
        await page.getByRole('button', { name: /Condiciones/ }).click();
        await expect(page.locator('#collapseOne')).toBeHidden();
        await page.getByRole('link', { name: 'Política de privacidad', exact: true }).click();
        await expect(page.locator('#modal-content')).toBeVisible();
        await expect(page.locator('#modal-content .modal_content')).toBeVisible();
        await expect(page.locator('#modal-content .modal_content')).not.toBeEmpty();
    });
}
