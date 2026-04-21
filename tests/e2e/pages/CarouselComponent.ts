import { type Locator, type Page } from '@playwright/test';

export class CarouselComponent{
    readonly root: Locator;
    readonly offerCards: Locator;
    readonly paginationDots: Locator;
    readonly slides: Locator;
    private readonly ottSelector = '.package-included';
    private readonly selectedClass = 'selected';

    constructor(page: Page, selector: string) {
        this.root = page.locator(selector);

        this.offerCards = this.root.locator('.splide__slide');
        this.paginationDots = this.root.locator('.splide__pagination button');
        this.slides = this.root.locator('.splide__slide:not(.splide__slide--clone)')
    }

    getOfferCardByIndex(index: number): Locator {
        return this.offerCards.nth(index);
    }

    /**
     * Devuelve el localizador de todos los OTTs de una tarjeta
     */
    getAllOtts(offerCard: Locator) : Locator {
        return offerCard.locator(this.ottSelector);
    }

    /**
     * Devuelve un OTT específico por su índice
     */
    getOttByIndex(offerCard: Locator, index: number): Locator {
        return this.getAllOtts(offerCard).nth(index);
    }

    /**
     * Comprueba si un elemento específico tiene la clase de selección
     */
    async isOttSelected(ott: Locator): Promise<boolean> {
        const classes = await ott.getAttribute('class');
        return classes?.includes(this.selectedClass) ?? false;
    }

    /**
     * Devuelve el localizador de los elementos seleccionados.
     */
    selectedOtts(offerCard: Locator): Locator {
        return offerCard.locator(`${this.ottSelector}.${this.selectedClass}`);
    }

    /**
     * HELPER: Devuelve el RegExp de la clase seleccionada.
     */
    get selectedRegExp() {
        return new RegExp(this.selectedClass);
    }
}