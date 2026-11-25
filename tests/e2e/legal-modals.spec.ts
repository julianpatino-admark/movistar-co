import { test, expect } from './fixtures';

for (const width of [360, 480, 1600]) {
    test(`documentos legales legibles y navegación anidada a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 1000 });
        await page.goto('/movil?tsource=0&utm_campaign=legales');
        await page.locator('.movil-footer').getByRole('link', { name: 'Política de privacidad', exact: true }).click();
        const privacy = page.locator('#modal-content');
        await expect(privacy).toBeVisible();
        await expect(privacy.getByRole('heading', { name: 'Políticas de privacidad', exact: true })).toBeVisible();
        await expect(privacy.locator('.modal_content')).toContainText('Konecta Digital Mk Agency');
        await page.evaluate(() => document.fonts.ready);
        await expect(privacy.locator('.legal-modal__title')).toHaveCSS('background-color', 'rgb(255, 190, 0)');
        await expect(privacy.locator('.modal_content')).toHaveCSS('font-size', '11px');
        expect(await privacy.locator('img').evaluateAll(images => images.every((image: HTMLImageElement) => image.complete && image.naturalWidth > 0 && Math.abs(image.getBoundingClientRect().width - image.naturalWidth) < .6 && Math.abs(image.getBoundingClientRect().height - image.naturalHeight) < .6))).toBeTruthy();
        expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBeTruthy();

        await privacy.locator('.privacy-btn').click();
        const manual = page.locator('#modal-manual');
        await expect(manual).toBeVisible();
        await expect(manual).toBeFocused();
        expect(await manual.locator('.modal_content').evaluate(el => el.scrollHeight > el.clientHeight)).toBeTruthy();
        await manual.locator('.modal_content').evaluate(el => { el.scrollTop = el.scrollHeight; });
        expect(await manual.locator('.modal_content').evaluate(el => el.scrollTop > 0)).toBeTruthy();
        await page.keyboard.press('Escape');
        await expect(manual).toBeHidden();
        await expect(privacy).toBeVisible();
        await expect(privacy.locator('.privacy-btn')).toBeFocused();
        await expect(page.locator('body')).toHaveClass(/modal-open/);
        await page.locator('.movil-footer a').first().evaluate((el: HTMLAnchorElement) => el.focus());
        await expect(privacy).toBeFocused();
        await privacy.getByRole('button', { name: 'Cerrar', exact: true }).click();
        await expect(privacy).toBeHidden();
        await expect(page.locator('body')).not.toHaveClass(/modal-open/);

        await page.locator('.movil-footer').getByRole('link', { name: 'Política de cookies', exact: true }).click();
        await expect(privacy.getByRole('heading', { name: 'Política de cookies', exact: true })).toBeVisible();
        await expect(privacy).toBeFocused();
        await expect(privacy.locator('.modal_content')).toContainText('Concepto de cookie');
        expect(await privacy.locator('.modal_content').evaluate(el => el.scrollHeight > el.clientHeight)).toBeTruthy();
        await page.keyboard.press('Escape');
        await expect(privacy).toBeHidden();
    });

    test(`consultar privacidad conserva los datos del formulario a ${width}px`, async ({ page }) => {
        await page.setViewportSize({ width, height: 1000 });
        await page.goto('/movil?tsource=0&utm_campaign=legales');
        await page.locator('#movil-offers .splide__slide.is-active .card-offer_cta button').first().click();
        const form = page.locator('#modal-velocidades');
        await form.locator('[name="phone"]').fill('3210000000');
        const link = form.locator('.form-simple_tyc a').first();
        await link.click();
        const privacy = page.locator('#modal-text');
        await expect(privacy).toBeVisible();
        await expect(privacy.getByRole('heading', { name: 'Políticas de privacidad', exact: true })).toBeVisible();
        await expect(privacy).toBeFocused();
        await page.keyboard.press('Escape');
        await expect(privacy).toBeHidden();
        await expect(form).toBeVisible();
        await expect(form.locator('[name="phone"]')).toHaveValue('3210000000');
        await expect(link).toBeFocused();
        await expect(page.locator('body')).toHaveClass(/modal-open/);
        await form.getByRole('button', { name: 'Cerrar', exact: true }).click();
        await expect(form).toBeHidden();
    });
}

test('el documento conserva el cierre y el scroll en pantallas bajas', async ({ page }) => {
    await page.setViewportSize({ width: 320, height: 568 });
    await page.goto('/movil?tsource=0');
    await page.locator('.movil-footer').getByRole('link', { name: 'Política de privacidad', exact: true }).click();
    const modal = page.locator('#modal-content');
    await expect(modal.locator('.modal_content')).toContainText('Konecta Digital Mk Agency');
    await expect(modal).toBeFocused();
    const box = await modal.locator('.modal-content').boundingBox();
    expect(box!.y).toBeGreaterThanOrEqual(16);
    expect(box!.y + box!.height).toBeLessThanOrEqual(552);
    expect(await modal.locator('.modal_content').evaluate(el => el.scrollHeight > el.clientHeight)).toBeTruthy();
    await modal.locator('.modal_content').evaluate(el => { el.scrollTop = el.scrollHeight; });
    await expect(modal.getByText('El titular autoriza recibir información', { exact: false })).toBeInViewport();
    await modal.getByRole('button', { name: 'Cerrar', exact: true }).click();
    await expect(page.locator('body')).not.toHaveClass(/modal-open/);
});
