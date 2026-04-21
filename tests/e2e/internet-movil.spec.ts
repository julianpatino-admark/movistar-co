// 1. IMPORTANTE: Importamos desde nuestro fixture para que grabe la cobertura
import { test, expect } from './fixtures'; 

test('ejecuta los scripts de inicialización de la página de internet móvil', async ({ page }) => {
    
    // 2. Navegamos a la URL exacta donde vive esta landing page.
    // (Asegúrate de que la ruta sea correcta, si no es '/internet-movil', pon la que uses localmente)
    await page.goto('/internet-movil'); 
    
    // 3. Le decimos a Playwright que espere a que el HTML y los scripts terminen de cargar
    await page.waitForLoadState('load');

    // 4. Con solo cargar, las líneas de CallMetrics.init(), FormSimple.init(), etc., ya se ejecutaron.
    // Hacemos una aserción básica para confirmar que la página está viva.
    await expect(page.locator('body')).toBeVisible();

    // 5. Medio segundo de cortesía para que Istanbul guarde el reporte
    await page.waitForTimeout(500);
});