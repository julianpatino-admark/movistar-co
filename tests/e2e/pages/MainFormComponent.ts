import { type Page, type Locator } from '@playwright/test';
import { FormularioData } from '../utilities/interfaces';

export class MainFormComponent {
    // Contenedor
    readonly page: Page;
    readonly root: Locator;

    // Selectores
    readonly inputNombre: Locator;
    readonly inputNumero: Locator;
    readonly optnServicios: Locator;
    readonly submitBtn: Locator;
    readonly tycCheckbox: Locator;
    readonly tituloGracias: Locator;
    readonly modalResponseText: Locator;

    // Errores
    readonly errorNombre: Locator;
    readonly errorNumero: Locator;
    readonly errorServicios: Locator;
    readonly errorTyc: Locator;

    public readonly expectedErrors = {
        required: 'Este campo es obligatorio.',
        invalidPhone: 'Por favor, introduce un teléfono válido.',
        duplicatedPhone: 'El teléfono ya fue agendado. Inténtalo de nuevo cuando hayan pasado al menos 24 horas.'
    }

    constructor(page: Page, selector: string, btnTxt: string = 'Llámame') {
        this.page = page;
        this.root = page.locator(selector);

        this.tituloGracias = page.getByRole('heading', { name: "¡Gracias!" });
        this.modalResponseText = page.locator('#modal-response .modal-response_text');

        this.inputNombre = this.root.getByPlaceholder('* Nombres y Apellidos');
        this.inputNumero = this.root.getByPlaceholder('* Número de Celular');
        this.optnServicios = this.root.locator(`${selector}-selectServicios`)
        this.tycCheckbox = this.root.getByRole('checkbox', { name: /acepto/i });

        this.submitBtn = this.root.getByRole('button', { name: btnTxt });

        this.errorNombre = this.root.locator(`${selector}-name-error`);
        this.errorNumero = this.root.locator(`${selector}-phone-error`);
        this.errorServicios = this.root.locator(`${selector}-selectServicios-error`);
        this.errorTyc = this.root.locator('[for="legal"]');
    }

    async fillForm({ nombre, telefono, servicios, aceptaTyc }: FormularioData): Promise<void> {
        if(nombre){
            await this.inputNombre.fill(nombre);
            await this.inputNombre.blur();
        }

        if(telefono){
            await this.inputNumero.fill(telefono);
            await this.inputNumero.blur();
        }

        if(servicios){
            await this.optnServicios.selectOption(servicios);
        }

        if(aceptaTyc !== undefined) {
            aceptaTyc ? await this.tycCheckbox.check() : await this.tycCheckbox.uncheck();
        }
    }

    async mockForm(status: number = 200) {
        await this.page.route('**/api/form/send', async (route) => {

            const isSuccess = status === 200;
            
            await route.fulfill({
                status: status,
                contentType: 'application/json',
                json: isSuccess
                    ? {
                        success: true,
                        message: "Formulario enviado correctamente."
                    } :
                    {
                        success: false,
                        errors: {
                            phone: [
                                "El teléfono ya fue agendado. Inténtalo de nuevo cuando hayan pasado al menos 24 horas."
                            ]
                        }
                    }
            });
        });
    }
}
