import { test, expect } from './fixtures';

const landings = [
    { path: '/', prefix: 'internet-movil', prices: ['$149.900', '$119.900'], c2c: ['FIBRA 900 MEGAS + TV + POSPAGO ILIMITADO : 149.900', 'FIBRA 900 MEGAS + POSPAGO ILIMITADO : 119.900'] },
    { path: '/internet-movil', prefix: 'internet-movil', prices: ['$149.900', '$119.900'], c2c: ['FIBRA 900 MEGAS + TV + POSPAGO ILIMITADO : 149.900', 'FIBRA 900 MEGAS + POSPAGO ILIMITADO : 119.900'] },
    { path: '/internet-hogar', prefix: 'hogar', prices: ['$109.155', '$84.900'], c2c: ['FIBRA 900 MEGAS + TV : 109.155', 'FIBRA 900 MEGAS SIMÉTRICAS : 84.900'] },
    { path: '/movil', prefix: 'movil', prices: ['$53.900', '$69.900'], c2c: ['MOVIL DE 60 GB : 53.900', 'MOVIL DE DATOS ILIMITADOS : 69.900'] },
];

for (const landing of landings) {
    test(`${landing.path} conserva diseño, navegación y producto al contratar`, async ({ page }) => {
        let submissions = 0;
        await page.route('**/api/form/send', route => { submissions++; return route.abort(); });
        await page.goto(`${landing.path}?tsource=0&utm_campaign=figma-audit`);
        await expect(page.locator('h1')).toHaveCount(1);
        await expect(page.locator('.movil-header__brand img')).toHaveAttribute('alt', 'Movistar y Tigo');
        await expect(page.locator('.movil-services [aria-current]')).toHaveAttribute('href', `${landing.path === '/' ? '/internet-movil' : landing.path}?tsource=0&utm_campaign=figma-audit`);
        const offers = page.locator(`#${landing.prefix}-offers`);
        await expect(offers.locator('.card-offer_price-number')).toHaveText(landing.prices);
        const width = page.viewportSize()?.width ?? 1600;
        const initialPlan = landing.prefix === 'movil' || width >= 900 || (landing.prefix === 'internet-movil' && width < 480) ? 0 : 1;
        await expect(offers.locator('.splide__slide.is-active .card-offer_price-number')).toHaveText(landing.prices[initialPlan]);
        for (const [index, c2c] of landing.c2c.entries()) {
            if ((page.viewportSize()?.width ?? 1600) < 900) {
                await offers.getByRole('tab', { name: `Ver plan ${index + 1}`, exact: true }).click();
            }
            await offers.locator('.card-offer_cta button').nth(index).click();
            const modal = page.locator('#modal-velocidades');
            await expect(modal).toBeVisible();
            await expect(modal.locator('[name="c2c"]')).toHaveValue(c2c);
            await expect(modal.locator('[name="tsource"]')).toHaveValue('0');
            await expect(modal.locator('[name="batch_id"]')).toHaveValue('MOVISTARCO_KDMA_C2CLN_Q12');
            await page.waitForFunction(() => !(window as any).jQuery('#modal-velocidades').data('bs.modal')?._isTransitioning);
            await modal.locator('.close').first().click();
            await expect(modal).toBeHidden();
        }
        if ((page.viewportSize()?.width ?? 1600) >= 1200) {
            const form = page.locator(`#c2c-${landing.prefix}-desktop`);
            await form.getByRole('button', { name: '¡Llámame!', exact: true }).click();
            await expect(form.locator('label.error:visible').first()).toBeVisible();
        }
        expect(submissions).toBe(0);
    });
}
