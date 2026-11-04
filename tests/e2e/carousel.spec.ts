import { test, expect } from './fixtures';

import { CarouselComponent } from './pages/CarouselComponent';

test.describe('Pruebas en el Banner Principal (Carrusel)', () => {
    let mainBanner: CarouselComponent;

    test.beforeEach(async ({ page }) => {
        await page.goto('');

        mainBanner = new CarouselComponent(page, '#carouselBanner');

        // Splide oculta el contenedor hasta que el JS lo monta (.is-initialized)
        await expect(mainBanner.root).toHaveClass(/is-initialized/);
    });

    // El banner principal tiene un único slide, por lo que Splide no muestra
    // paginación ni permite deslizar (antes había varios slides).
    test('el banner se monta, es visible y su único slide está activo', async () => {
        await expect(mainBanner.root).toBeVisible();

        await expect(mainBanner.slides).toHaveCount(1);
        await expect(mainBanner.slides.first()).toHaveClass(/is-active/);
        // Con un solo slide Splide crea el punto de paginación pero lo oculta
        await expect(mainBanner.paginationDots.first()).toBeHidden();
    });
});
