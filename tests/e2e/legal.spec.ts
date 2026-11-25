import { test, expect } from './fixtures';

for (const width of [360, 480, 1600]) {
    for (const [path, title] of [['privacy', 'Política de privacidad'], ['cookies', 'Política de cookies']]) {
        test(`${title} usa el diseño actual a ${width}px`, async ({ page }) => {
            await page.setViewportSize({ width, height: 1000 });
            const response = await page.goto(`/${path}?tsource=0&utm_campaign=legal`);
            expect(response?.status()).toBe(200);
            await expect(page.getByRole('heading', { level: 1, name: title, exact: true })).toBeVisible();
            await expect(page.locator('.movil-header, .movil-footer')).toHaveCount(2);
            await expect(page.locator('.cta-mobile_wrapper, [data-toggle="form-simple"]')).toHaveCount(0);
            await page.evaluate(() => document.fonts.ready);
            expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBeTruthy();
            await expect(page.locator('#navbarMobileCollapse a').first()).toHaveAttribute('href', /tsource=0&utm_campaign=legal$/);

            if (path === 'privacy') {
                await page.locator('#legal-content .privacy-btn').click();
            } else {
                await page.getByRole('link', { name: 'Política de privacidad', exact: true }).click();
                await expect(page.locator('#modal-content .modal_content')).toBeVisible();
                await page.locator('#modal-content .privacy-btn').click();
            }
            const manual = page.locator('#modal-manual');
            await expect(manual).toBeVisible();
            await expect(manual.locator('.modal_content')).not.toBeEmpty();
            await expect(manual.locator('.modal-header')).toHaveCSS('background-color', 'rgb(0, 30, 180)');
            await manual.getByRole('button', { name: 'Cerrar', exact: true }).click();
            await expect(manual).toBeHidden();
        });
    }
}
