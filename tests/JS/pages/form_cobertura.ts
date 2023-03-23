const { I } = inject();
const { container } = require('codeceptjs');

import { Default, FormFields } from "./default";

interface CoberturaFields extends FormFields{
    provinceSelector: string,
    citySelector: string,
    townSelector: string,
    neighbhtInput: string,
    noNeighbhtCheckbox: string,
}

interface CoberturaData {
    province: string,
    city: string,
    town?: string,
    address: string
}

class CoberturaForm extends Default {

    // setting locators
    fields;

    constructor() {
        let fields:CoberturaFields = {
            provinceSelector: '#selectProvince',
            citySelector: '#selectCity',
            townSelector: '#selectTown',
            neighbhtInput: '#inputNeighborhood',
            noNeighbhtCheckbox: '#noNeighborhoodFinded',
            cellphoneInput: '#userCoberturaCellPhone',
            legalCheckbox: `input[name="legal"]`,
        }
        super(fields);
    }

    /**
     * Simplifies the use of the "locate" selector to find the option within the given container.
     * @param {String} expectedValue - The value of the option expected to be found.
     * @param {String} container - The parent selector containing the option to be found.
     */
    optionLocator(expectedValue:string, container:string){
        return locate('option').withAttr({ "value" : expectedValue }).inside(container);
    }

    /**
     * Change the values of each selector and trigger event.
     * @param {CoberturaData} data - The value of the option expected to be found.
     */
    async changeSelectFields(data:CoberturaData) {
        const tryTo = container.plugins("tryTo");

        I.waitForElement(this.optionLocator(data.province, this.fields.provinceSelector));
        I.selectOption(this.fields.provinceSelector, data.province);

        I.waitForElement(this.optionLocator(data.city, this.fields.citySelector));
        I.selectOption(this.fields.citySelector, data.city);

        if(await tryTo(() => I.seeElement(this.fields.townSelector))) I.selectOption(this.fields.townSelector, data.town);

        I.fillField(this.fields.neighbhtInput, data.address);

        super.fillForm();
    }

    async checkNoNeighborhood() {

        super.fillForm();

        I.checkOption(this.fields.noNeighbhtCheckbox);

        I.waitForElement(this.optionLocator("Bogotá D.C.", this.fields.provinceSelector));
    }

    async fillWithTown() {
        const data:CoberturaData = {
            province: "Bogotá D.C.",
            city: "Bogotá D.C.",
            town: "Rafael Uribe Uribe",
            address: "Calle 123 # 01 - 50",
        }
        await this.changeSelectFields(data)
    }

    async fillWithoutTown() {
        const data:CoberturaData = {
            province: "Chocó",
            city: "Bahía Solano",
            address: "Calle 123 # 01 - 50"
        }
        await this.changeSelectFields(data)
    }

}

module.exports = new CoberturaForm();
