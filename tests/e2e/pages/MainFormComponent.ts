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

    // Errores
    readonly errorNombre: Locator;
    readonly errorNumero: Locator;
    readonly errorServicios: Locator;
    readonly errorTyc: Locator;

    constructor(page: Page, selector: string, btnTxt: string = 'Llámenme') {
        this.page = page;
        this.root = page.locator(selector);

        this.inputNombre = this.root.getByPlaceholder('* Nombres y Apellidos');
        this.inputNumero = this.root.getByPlaceholder('* Número de Celular');
        this.optnServicios = this.root.getByPlaceholder('')
    }
}