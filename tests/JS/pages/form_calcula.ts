const { I } = inject();

import {clienteNoClienteEnum, Default, FormFields} from "./default";

interface CalculaFields extends FormFields{
    fibraToggle: string,
    movilToggle: string,
    clienteNoCliente: string
}

export default class CalculaForm extends Default {

    // setting locators
    fields;

    constructor() {
        let fields:CalculaFields = {
            fibraToggle: `label[for="%s-calcula-select-fibra"]`,
            movilToggle: `label[for="%s-calcula-select-movil"]`,
            clienteNoCliente: "select#%s-select-clientenocliente",
            cellphoneInput: '$input-c2c-phone',
            legalCheckbox: 'input[name="legal"]',
        };
        super(fields);
    }

    fillForm(clienteNoClienteSelect:clienteNoClienteEnum=clienteNoClienteEnum.no) {

        I.checkOption(this.fields.fibraToggle);

        I.checkOption(this.fields.movilToggle);

        I.selectOption(this.fields.clienteNoCliente, clienteNoClienteSelect);

        I.fillField(this.fields.cellphoneInput, 3000000001);

        I.checkOption(this.fields.legalCheckbox)

    }


    /**
     * Uncheck some toggle options by an array of params
     * @param {string[]} options['fibra', 'movil'] - An array of string with the keys of the class to uncheck.
     */
    uncheckSomeOptions(options:String[]) {

        options.forEach(toggleField => I.uncheckOption(this.fields[`${toggleField}Toggle`]));

    };
}

module.exports = new CalculaForm();
