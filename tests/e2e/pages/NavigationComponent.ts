import { type Page, type Locator } from '@playwright/test';

export type MainNavLinks = 'Internet Hogar + Móvil' | 'Internet Hogar' | 'Móvil';
export type MenuLocation = 'header' | 'carruselPrincipal';

export class NavigationComponent {
    readonly page: Page;

    readonly mainNav: Locator;
    readonly carouselNav: Locator;

    readonly hamburgerMenuBtn: Locator;

    constructor(page: Page){
        this.page = page;

        this.mainNav = page.locator('.movil-header__desktop-navigation:visible, .movil-header__navigation:visible');
        this.carouselNav = page.locator('.movil-services');

        this.hamburgerMenuBtn = page.locator('.movil-header__menu');
    }

    async clickNavLink(menu: MenuLocation, linkName: MainNavLinks): Promise<void> {
        if (menu === 'header' && !await this.mainNav.isVisible()) {
            await this.hamburgerMenuBtn.click();
        }
        const containers = {
            'header': this.mainNav,
            'carruselPrincipal': this.carouselNav
        };

        await containers[menu].getByRole('link', { name: linkName, exact: true }).click();
    };
}