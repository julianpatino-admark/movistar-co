const { I } = inject();
import { Default, FormFields } from "./default";


interface ClicToCallFields extends FormFields{
    dniInput: string,
    selectContratar: string,
    selectServicios: string,
}

interface ParamsFill {
    contrata: string,
    services: string
}

export default class FormClicToCall extends Default {
    protected fields:ClicToCallFields;

    constructor() {
        let fields = {
            selectContratar: 'select[name="contratar"]',
            selectServicios: 'select[name="servicios"]',
            cellphoneInput: '$input-c2c-phone',
            dniInput: `input[name="dni"]`,
            legalCheckbox: 'input[name="legal"]',
        };
        super(fields);
    }

    public getC2cElementBtn(value):CodeceptJS.LocatorOrString {
        return locate('a').withAttr({ "data-c2c" : value })
    };

    public fillForm(showFields=false, { services, contrata } = {} as ParamsFill) {

        if(showFields){
            I.selectOption(this.fields.selectContratar, contrata);
            I.selectOption(this.fields.selectServicios, services);
        }

        I.fillField(this.fields.cellphoneInput, 3211234567);

        I.checkOption(this.fields.legalCheckbox)

    }
}

module.exports = new FormClicToCall();
