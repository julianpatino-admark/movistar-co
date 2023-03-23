const { I } = inject();
import {clienteNoClienteEnum, Default, FormFields} from "./default";


interface ClicToCallFields extends FormFields{
    clienteNoCliente: string
}

export default class FormClicToCall extends Default {
    fields;

    constructor() {
        let fields:ClicToCallFields = {
            clienteNoCliente: "select#%s-select-clientenocliente",
            cellphoneInput: '$input-c2c-phone',
            legalCheckbox: 'input[name="legal"]',
        };
        super(fields);
    }

    getC2cElementBtn(value):CodeceptJS.LocatorOrString {
        return locate('a').withAttr({ "data-c2c" : value })
    };

    fillForm(clienteNoClienteSelect:clienteNoClienteEnum=clienteNoClienteEnum.no) {

        I.fillField(this.fields.cellphoneInput, 3210000001);

        I.selectOption(this.fields.clienteNoCliente, clienteNoClienteSelect);

        I.checkOption(this.fields.legalCheckbox)

    }
}

module.exports = new FormClicToCall();
