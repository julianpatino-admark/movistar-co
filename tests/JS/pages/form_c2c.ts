const { I } = inject();
import {Default, FormFields} from "./default";


interface ClicToCallFields extends FormFields{
    dniInput: string
}

export default class FormClicToCall extends Default {
    fields;

    constructor() {
        let fields:ClicToCallFields = {
            cellphoneInput: '$input-c2c-phone',
            dniInput: `input[name="dni"]`,
            legalCheckbox: 'input[name="legal"]',
        };
        super(fields);
    }

    getC2cElementBtn(value):CodeceptJS.LocatorOrString {
        return locate('a').withAttr({ "data-c2c" : value })
    };

    fillForm() {

        I.fillField(this.fields.cellphoneInput, 3211234567);

        I.fillField(this.fields.dniInput, 123456789);

        I.checkOption(this.fields.legalCheckbox)

    }
}

module.exports = new FormClicToCall();
