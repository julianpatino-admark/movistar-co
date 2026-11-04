import { test as baseTest } from '@playwright/test';

export { expect } from '@playwright/test';

/**
 * Fixture base (sin cobertura de Vite/Istanbul: el build ahora es gulp + webpack).
 *
 * El bundle JS se inyecta en el evento `load` de la página (ver footer-scripts),
 * por lo que `page.goto` resuelve ANTES de que el JS esté listo. Esperamos a que
 * jQuery + jquery-validation estén disponibles para evitar tests inestables.
 */
export const test = baseTest.extend({
  page: async ({ page }, use) => {
    const goto = page.goto.bind(page);

    page.goto = (async (url: string, options?: Parameters<typeof goto>[1]) => {
      const response = await goto(url, options);

      if (response && response.status() === 200) {
        await page
          .waitForFunction(
            () => (window as any).jQuery && (window as any).jQuery.fn.validate,
            null,
            { timeout: 8000 }
          )
          .catch(() => { /* páginas sin bundle JS (gracias, cookies, privacidad) */ });
      }

      return response;
    }) as typeof page.goto;

    await use(page);
  },
});
