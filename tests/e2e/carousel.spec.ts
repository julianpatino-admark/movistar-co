import { test, expect } from '@playwright/test';

import { CarouselComponent } from './pages/CarouselComponent';

test.describe('Pruebas en el Banner Principal (Carrusel)', () => {
    let mainBanner: CarouselComponent;

    test.beforeEach(async ({ page }) => {
        await page.goto('');

        mainBanner = new CarouselComponent(page, '#carouselBanner');
    });

    test.use({ 
        viewport: { width: 375, height: 667 },
        hasTouch: true, // Habilita eventos táctiles
        isMobile: true  // Le dice al navegador que es un dispositivo móvil
    });

    test('debe deslizar al slide correcto al hacer clic en los puntos de paginación', async () => {
        const dotsCount = await mainBanner.paginationDots.count();

        expect(dotsCount).toBeGreaterThan(1);

        for(let i = 0; i < dotsCount; i++){
            const dot = mainBanner.paginationDots.nth(i);
            const targetSlide = mainBanner.slides.nth(i);

            await dot.click();

            await expect(targetSlide).toHaveClass(/is-active/);
            await expect(dot).toHaveClass(/is-active/);
        }

    });

    test('debe cambiar de slide al hacer swipe en vista móvil', async ({ page }) => {
        const slide1 = mainBanner.slides.nth(0);
        const slide2 = mainBanner.slides.nth(1);
        await expect(slide2).toHaveClass(/is-active/);

        const bannerBox = await mainBanner.root.boundingBox();
        expect(bannerBox).not.toBeNull();

        if (bannerBox) {
            const startX = bannerBox.x + bannerBox.width * 0.2;
            const endX = bannerBox.x + bannerBox.width * 0.8;
            const startY = bannerBox.y + bannerBox.height / 2;

            await page.mouse.move(startX, startY);
            await page.mouse.down();

            await page.mouse.move(endX, startY, { steps: 20 }); 
            await page.mouse.up();

            await expect(slide1).toHaveClass(/is-active/);

            await expect(slide2).not.toHaveClass(/is-active/);
        }
    });
});