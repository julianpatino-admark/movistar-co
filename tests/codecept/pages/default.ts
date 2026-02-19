const { I } = inject();

interface FormFields {
    cellphoneInput: string,
    legalCheckbox: string
}

interface InitialState {
    submitButton:string,
    fields: FormFields
}

class Default {

    protected fields:FormFields;

    private submitButton:string;
    
    protected root:string;

    private initialState: InitialState;

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
    public mock() {
        I.mockRoute('**/api/form/send', route => {
            route.fulfill({
                status: 200,
                contentType: 'application/json',
                headers: {"Access-Control-Allow-Origin": "*"},
                body: JSON.stringify({
                    detail: "InConcert.TRUE",
                    status: true
                })
            });
        })
    }

    /**
     * Function that validates if the form has any error and if it is shown or not depending on the boolean parameter.
     * @param {String} root - The string with the id key to format the locators with that.
     */
    public initFields(root:string) {
        I.say("Initialize fields with value: "+root)

        for (const property in this.fields){
            this.fields[property] = String(this.fields[property]).replace("%s", root);
        }
        this.submitButton = String(this.initialState.submitButton).replace("%s", root);
    }

    /**
     * Fill the default fields with dummy data.
     */
    public fillForm(showFields:boolean=false, payload:Object) {

        I.fillField(this.fields.cellphoneInput, 3000000001);

        I.checkOption(this.fields.legalCheckbox)

    }

    /**
     * Check if the form has any error and if it is shown or not depending on the boolean parameter.
     * @param {Boolean} [withErrors=false] - If true, then check if error messages are displayed.
     * @param {Object} [validators={phone:"#phone-error", privacy: "#privacy-error"}] - Object with keys and locators to see error labels on forms.
     */
    public validForm(withErrors:boolean=false, validators={} ):void{
        let labelListSelector = {
            phone: "#phone-error",
            privacy : locate("label.error.d-block").inside('div.form-simple_tyc'),
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
    public sendFormMock(withMock:boolean=true) {
        if(withMock) this.mock();

        I.click(this.submitButton);
    }
}

export { FormFields, Default }