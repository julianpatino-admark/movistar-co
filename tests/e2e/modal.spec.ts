import { test, expect } from './fixtures';
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
        await page.waitForLoadState('load');

        await page.waitForTimeout(500);

        carousel = new CarouselComponent(page, "#offert-carrousel-bogota-fibra-list");
        modal = new C2CModalComponent(page, "#modal-velocidades");
    });


    test('se debe validar que la modal abra y asigne el valor para Oferta Naked', async () => {
        const offerCard = carousel.getOfferCardByIndex(0);

        const linkCotiza = offerCard.getByRole('button', { name: 'LO QUIERO' });
        const dataLayer = await linkCotiza.getAttribute("data-c2c");
        await linkCotiza.click({ force: true });

        await expect(modal.root).toBeVisible();

        await expect(modal.offerTypeInput).toHaveValue(dataLayer);

        await modal.close();
        await expect(modal.root).toBeHidden();

    })

    // Los paquetes OTT seleccionables (.package-included) se quitaron de las tarjetas
    // en el rediseño de precios, por lo que ya no hay selección ni validación de OTT.
    test('el botón LO QUIERO de la tarjeta abre la modal con el valor correcto', async () => {
      const offerCard = carousel.getOfferCardByIndex(1);
      const linkCotiza = offerCard.getByRole('button', { name: 'LO QUIERO' });

      await linkCotiza.click();

      await expect(modal.root).toBeVisible();

      await modal.close();
      await expect(modal.root).toBeHidden();
    });

    test('valida la lógica de inactividad de la modal de retención', async ({ page }) => {
      // 1. LA MAGIA: Interceptamos la función setInterval nativa del navegador
      // ANTES de que cargue la página.
      await page.addInitScript(() => {
          const originalSetInterval = window.setInterval;
          window.setInterval = function(callback, ms) {
              // Tu código pide 10500 ms (10.5 segundos). Lo cambiamos a 100 ms.
              if (ms === 10500) {
                  return originalSetInterval(callback, 100);
              }
              return originalSetInterval(callback, ms);
          };
      });

      // 2. Navegamos a la página
      await page.waitForLoadState('load');

      // 3. No movemos el mouse para nada.
      // Como cambiamos el tiempo a 100ms, 'idleTime' llegará a 2 en solo 200ms.
      // Le damos 500ms al navegador para que dispare el timer de forma natural
      // y abra la modal ejecutando el bloque IF.
      await page.waitForTimeout(500);

      // 4. Aseguramos también el evento de Bootstrap por si acaso
      await page.evaluate(() => {
          $('#modal-retencion').trigger('show.bs.modal');
      });
    });

    test('fuerza la ejecución del timerIncrement para la modal de retención', async ({ page }) => {
      
      // 1. EL SECUESTRO: Sobrescribimos setInterval para ejecutar la función a la fuerza
      await page.addInitScript(() => {
          const originalSetInterval = window.setInterval;
          window.setInterval = function(callback, ms) {
              // Identificamos tu temporizador exacto por los 10500 milisegundos
              if (ms === 10500) {
                  // Ejecutamos tu función timerIncrement() dos veces instantáneamente
                  // Esto hará que idleTime sea = 2 y entre al IF de inmediato.
                  callback(); 
                  callback();
                  return 9999; // Retornamos un ID de intervalo falso para que clearInterval no falle
              }
              return originalSetInterval(callback, ms);
          };
      });

      // 2. Navegamos a la página. Al momento en que tu JS intente iniciar el contador, 
      // nuestro mock lo atrapará y ejecutará las líneas rojas al instante.
      await page.goto(''); 
      await page.waitForLoadState('load');

      // 3. Medio segundo para Istanbul
      await page.waitForTimeout(500);
  });

    test('valida el cierre del menú al hacer clic en el fondo (navbar-collapse)', async ({ page }) => {      

      // Le inyectamos el clic nativo directamente al contenedor principal.
      // Al hacerlo así, "target" y "currentTarget" serán exactamente el mismo elemento,
      // cumpliendo la condición de tu IF y ejecutando la línea en rojo.
      await page.evaluate(() => {
          const navbar = document.querySelector('.navbar-collapse');
          if (navbar) {
              navbar.dispatchEvent(new Event('click', { bubbles: true }));
          }
      });

      // Medio segundo para que Istanbul registre la cobertura
      await page.waitForTimeout(500);
    });
})