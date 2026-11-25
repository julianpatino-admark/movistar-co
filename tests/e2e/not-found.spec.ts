import { test, expect } from './fixtures';

for (const width of [360, 480, 1600]) {
    test(`404 responsive y recuperación de navegación a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 1000 });
        const errors: string[] = [];
        page.on('pageerror', error => errors.push(error.message));
        const response = await page.goto('/ofertas/que/no-existen?tsource=0&utm_campaign=error404');
        expect(response?.status()).toBe(404);
        await expect(page.getByRole('heading', { name: 'Página no encontrada', exact: true })).toBeVisible();
        await expect(page.locator('h1')).toHaveCount(1);
        await expect(page.locator('#modal-retencion, [data-toggle="form-simple"]')).toHaveCount(0);
        await page.evaluate(() => document.fonts.ready);
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBeTruthy();
        await expect(page.locator('.not-found__image img')).toBeVisible();
        expect(await page.locator('.not-found__image img').evaluate((img: HTMLImageElement) => img.complete && img.naturalWidth > 0)).toBeTruthy();

        if (width < 1200) {
            await page.getByRole('button', { name: 'Abrir menú de servicios' }).click();
            await expect(page.locator('#navbarMobileCollapse')).toHaveClass(/\bshow\b/);
            await expect(page.locator('#navbarMobileCollapse a[href="/internet-hogar?tsource=0&utm_campaign=error404"]')).toBeVisible();
            await page.getByRole('button', { name: 'Abrir menú de servicios' }).click();
            await expect(page.locator('#navbarMobileCollapse')).toBeHidden();
        }

        await page.getByRole('button', { name: /Condiciones/ }).click();
        await expect(page.locator('#collapseOne')).toHaveClass(/\bshow\b/);
        await page.getByRole('button', { name: /Condiciones/ }).click();
        await expect(page.locator('#collapseOne')).toBeHidden();
        await page.getByRole('link', { name: 'Política de privacidad', exact: true }).click();
        await expect(page.locator('#modal-content .modal_content')).toBeVisible();
        await expect(page.locator('#modal-content .modal_content')).not.toBeEmpty();
        await page.locator('#modal-content .close').click();
        await expect(page.locator('#modal-content')).toBeHidden();

        const home = page.getByRole('link', { name: 'Llévame a la home', exact: true });
        await expect(home).toHaveAttribute('href', /\?tsource=0&utm_campaign=error404$/);
        await home.click();
        await expect(page).toHaveURL(/\/\?tsource=0&utm_campaign=error404$/);
        await expect(page.locator('#internet-movil-content')).toBeVisible();
        expect(errors).toEqual([]);
    });
}
