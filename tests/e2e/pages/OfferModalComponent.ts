import { type Page, type Locator } from '@playwright/test';

export class C2CModalComponent {
    readonly root: Locator;
    readonly offerTypeInput: Locator;
    readonly closeBtn: Locator;

    constructor(page: Page, selector: string) {
        this.root = page.locator(selector);
        this.offerTypeInput = this.root.locator('[name="c2c"]');

        this.closeBtn = this.root.getByLabel('Close');
    }

    async close(){
        await this.closeBtn.click();

        await this.root.waitFor({ state: 'hidden' });
    }
}