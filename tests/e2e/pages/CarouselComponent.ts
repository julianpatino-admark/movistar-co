import { type Locator, type Page } from '@playwright/test';

export class CarouselComponent{
    readonly root: Locator;
    readonly offerCards: Locator;
    readonly paginationDots: Locator;
    readonly slides: Locator;

    constructor(page: Page, selector: string) {
        this.root = page.locator(selector);

        this.offerCards = this.root.locator('.splide__slide');
        this.paginationDots = this.root.locator('.splide__pagination button');
        this.slides = this.root.locator('.splide__slide:not(.splide__slide--clone)')
    }

    getOfferCardByIndex(index: number): Locator {
        return this.offerCards.nth(index);
    }
}