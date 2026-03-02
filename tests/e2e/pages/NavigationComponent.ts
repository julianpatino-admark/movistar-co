import { type Page, type Locator } from '@playwright/test';

export type MainNavLinks = 'Internet Hogar + Móvil' | 'Internet Hogar' | 'Móvil' | 'Solo Internet + Pospago' | 'Trío + Pospago';
export type MenuLocation = 'header' | 'carruselPrincipal' | 'carruselSecundario';

export class NavigationComponent {
    readonly page: Page;

    readonly mainNav: Locator;
    readonly carouselNav: Locator;
    readonly secondaryCarouselNav: Locator;

    readonly hamburgerMenuBtn: Locator;

    constructor(page: Page){
        this.page = page;

        this.mainNav = page.locator('.header-container .navbar-nav');
        this.carouselNav = page.locator('nav.nav-carousel');
        this.secondaryCarouselNav = page.locator('nav.carousel-navbar');

        this.hamburgerMenuBtn = page.locator('.navbar-toggler');
    }

    async clickNavLink(menu: MenuLocation, linkName: MainNavLinks): Promise<void> {
        const containers = {
            'header': this.mainNav,
            'carruselPrincipal': this.carouselNav,
            'carruselSecundario': this.secondaryCarouselNav
        };

        await this.mainNav.getByRole('link', { name: linkName }).click();
    };
}