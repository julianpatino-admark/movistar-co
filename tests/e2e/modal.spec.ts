import { test, expect } from './fixtures';
import { CarouselComponent } from './pages/CarouselComponent';
import { C2CModalComponent } from './pages/OfferModalComponent';

test.describe('Contratación de los planes de Internet + Móvil', () => {
    test.use({ viewport: { width: 1600, height: 1000 } });

    for (const [index, c2c] of [
        [0, 'FIBRA 900 MEGAS + TV + POSPAGO ILIMITADO : 149.900'],
        [1, 'FIBRA 900 MEGAS + POSPAGO ILIMITADO : 119.900'],
    ] as const) {
        test(`el plan ${index + 1} abre su formulario con el producto correcto`, async ({ page }) => {
            await page.goto('/internet-movil');
            const carousel = new CarouselComponent(page, '#internet-movil-offers');
            const modal = new C2CModalComponent(page, '#modal-velocidades');
            await carousel.getOfferCardByIndex(index).getByRole('button', { name: '¡LO QUIERO!', exact: true }).click();
            await expect(modal.root).toBeVisible();
            await expect(modal.offerTypeInput).toHaveValue(c2c);
            await modal.close();
            await expect(modal.root).toBeHidden();
        });
    }
});
