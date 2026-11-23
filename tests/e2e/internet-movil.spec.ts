import { test, expect } from './fixtures';

for (const path of ['/', '/internet-movil']) {
    test(`${path} muestra el diseño Figma y conserva la contratación`, async ({ page }) => {
        await page.route('**/api/form/send', route => route.abort());
        await page.route('https://www.googletagmanager.com/**', route => route.abort());
        await page.goto(`${path}?tsource=0&utm_campaign=figma`);

        await expect(page.locator('body')).toHaveClass(/internet-movil-redesign/);
        await expect(page.locator('h1')).toHaveCount(1);
        await expect(page.locator('#internet-movil-banners')).toHaveClass(/is-initialized/);
        await expect(page.locator('#internet-movil-offers')).toHaveClass(/is-initialized/);
        await expect(page.locator('#internet-movil-offers .card-offer_price-number')).toHaveText(['$149.900', '$119.900']);
        await expect(page.locator('.movil-services [aria-current]')).toHaveAttribute('href', '/internet-movil?tsource=0&utm_campaign=figma');

        if ((page.viewportSize()?.width ?? 1600) < 900) {
            await page.locator('#internet-movil-offers').getByRole('tab', { name: 'Ver plan 1' }).click();
        }
        await page.locator('#internet-movil-offers-slide01 .card-offer_cta button').click();
        const modal = page.locator('#modal-velocidades');
        await expect(modal).toBeVisible();
        await expect(modal.locator('[name="c2c"]')).toHaveValue('FIBRA 900 MEGAS + TV + POSPAGO ILIMITADO : 149.900');
        await expect(modal.locator('[name="tsource"]')).toHaveValue('0');
        await expect(modal.locator('[name="batch_id"]')).toHaveValue('MOVISTARCO_KDMA_C2CLN_Q12');
        await page.waitForFunction(() => !(window as any).jQuery('#modal-velocidades').data('bs.modal')?._isTransitioning);
        await modal.locator('.close').first().click();
        await expect(modal).toBeHidden();
    });
}
