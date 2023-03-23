const { I } = inject();
import { clienteNoClienteEnum } from "../utilities/main"

interface FormFields {
    cellphoneInput: string,
    legalCheckbox: string
}

interface InitialState {
    submitButton:string,
    fields: FormFields
}

class Default {

    root:string;
    submitButton:string;
    fields:FormFields;

    initialState: InitialState;

    constructor(
        fields:FormFields = {
            cellphoneInput: '$input-c2c-phone',
            legalCheckbox: 'input[name="legal"]'
        },
        submitButton: string = `button#btn-submit-%s`,
    ) {
        this.submitButton = submitButton;
        this.fields = fields;

        this.initialState = {
            submitButton:this.submitButton,
            fields: { ...this.fields }
        }
    }

    reinitialize() {
        this.submitButton = this.initialState.submitButton;
        this.fields = { ...this.initialState.fields };
    }

    /**
     * Intercepts the request to the server and simulates a response with a custom data in the message
     */
    mock() {
        I.mockRoute('**/api/form/filter', route => {
            route.fulfill({
                status: 200,
                contentType: 'application/json',
                headers: {"Access-Control-Allow-Origin": "*"},
                body: JSON.stringify({
                    detail: "InConcert.TRUE",
                    status: true,
                    message:"<img width='95' height='95' src='/img/common/icons-check-orange.svg'><h3>Tu solicitud se ha enviado correctamente<\/h3><p>Muchas gracias por tu interés, <br> nos pondremos en contacto lo antes posible.<\/p>",
                })
            });
        })
    }

    /**
     * Function that validates if the form has any error and if it is shown or not depending on the boolean parameter.
     * @param {String} root - The string with the id key to format the locators with that.
     */
    initFields(root:string) {
        I.say("Initialize fields with value: "+root)

        for (const property in this.fields){
            this.fields[property] = String(this.fields[property]).replace("%s", root);
        }
        this.submitButton = String(this.initialState.submitButton).replace("%s", root);
    }

    /**
     * Fill the default fields with dummy data.
     */
    fillForm() {

        I.fillField(this.fields.cellphoneInput, 3000000001);

        I.checkOption(this.fields.legalCheckbox)

    }

    /**
     * Check if the form has any error and if it is shown or not depending on the boolean parameter.
     * @param {Boolean} [withErrors=false] - If true, then check if error messages are displayed.
     * @param {Object} [validators={phone:"#phone-error", privacy: "#privacy-error"}] - Object with keys and locators to see error labels on forms.
     */
    validForm(withErrors:boolean=false, validators={} ):void{
        let labelListSelector = {
            phone: "#phone-error",
            privacy : locate("label.error.d-block").inside('div.privacy-policy'),
            ...validators
        }

        for (const element in labelListSelector) {
            if(withErrors) I.seeElement(labelListSelector[element]);
            else I.dontSeeElement(labelListSelector[element])
        }
    }

    /**
     * Function to click default button and send data.
     * @param {Boolean} [withMock=true] - If false, then the mock function is not triggered.
     */
    sendFormMock(withMock:boolean=true) {
        if(withMock) this.mock();

        I.click(this.submitButton);
    }
}

export { clienteNoClienteEnum, FormFields, Default }