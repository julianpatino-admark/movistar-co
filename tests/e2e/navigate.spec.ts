import { test, expect } from '@playwright/test';
import { NavigationComponent } from './pages/NavigationComponent';

test.describe('Pruebas de Navegación Principal', () => {
    let navigation: NavigationComponent;

    const mainUrls = {
        tsource: '?tsource=1234',
        internetMovil: '/internet-movil',
        internetMovilTrio: 'trio'
    }

    test.beforeEach(async ({ page }) => {
        await page.goto(`/${mainUrls.tsource}`);

        navigation = new NavigationComponent(page);
    });

    test('el menú del header navega de manera correcta y mantiene el tsource', async ({ page }) => {
        await navigation.clickNavLink('header', 'Internet Hogar + Móvil');

        const urlEsperada = new RegExp(`.*${mainUrls.internetMovil}.*\\${mainUrls.tsource}`);
        await expect(page).toHaveURL(urlEsperada);
    });

    test('el menú principal del carrusel navega de manera correcta', async ({ page }) => {
        await navigation.clickNavLink('carruselPrincipal', 'Internet Hogar + Móvil');

        await expect(page).toHaveURL(new RegExp(`.*${mainUrls.internetMovil}`));
    });

    test('el menu secundario del carrusel navega de manera correcta', async ({ page }) => {
        await navigation.clickNavLink('carruselSecundario', 'Trío + Pospago');

        await expect(page).toHaveURL(new RegExp(`.*${mainUrls.internetMovilTrio}`));
    });
});

test.describe('Pruebas de Páginas de Error', () => {
    test('debe validar que la página inexistente responda con 404', async ({ page }) => {
        const response = await page.goto('/pagina-erronea-e-inexistente');
        
        // Validamos a nivel de red (Backend)
        expect(response?.status()).toBe(404);

        // Validamos a nivel visual (Frontend)
        await expect(page).toHaveTitle(/Error/i);
    });
});
