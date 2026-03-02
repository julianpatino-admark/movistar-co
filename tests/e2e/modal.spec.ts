import { test, expect } from '@playwright/test';
import { CarouselComponent } from './pages/CarouselComponent';
import { C2CModalComponent } from './pages/OfferModalComponent';

const testData = [
  {
    offerName: 'Oferta Naked',
    expectedValue: 'FIBRA 900 Megas + MB COMBO PLUS : 53.495'
  },
  {
    offerName: 'Oferta Win Play',
    expectedValue: 'FIBRA 900 Megas + MB COMBO PLUS : 57.495'
  },
  {
    offerName: 'Oferta Disney',
    expectedValue: 'FIBRA 900 Megas + MB COMBO PLUS : 57.495'
  },
  {
    offerName: 'Oferta Disney + Win',
    expectedValue: 'FIBRA 900 Megas + MB COMBO PLUS : 61.495'
  }
];

test.describe('Pruebas las modales de ofertas', () => {

    test.use({ viewport: { width: 1920, height: 1080 } });

    let carousel: CarouselComponent;
    let modal: C2CModalComponent;

    test.beforeEach(async ({ page }) => {
        await page.goto('');

        carousel = new CarouselComponent(page, "#offer-carrousel-list");
        modal = new C2CModalComponent(page, "#modal-velocidades");
    });

    for(const [index, data] of testData.entries()){

        test(`se debe validar que la modal abra y asigne el valor para ${data.offerName}`, async () => {
            const offerCard = carousel.getOfferCardByIndex(index);

            const linkCotiza = offerCard.getByRole('button', { name: 'LO QUIERO' });
            await linkCotiza.click({ force: true });

            await expect(modal.root).toBeVisible();

            await expect(modal.offerTypeInput).toHaveValue(data.expectedValue);

            await modal.close();
            await expect(modal.root).toBeHidden();

        })

    }
})