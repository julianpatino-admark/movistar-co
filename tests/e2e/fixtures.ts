import { test as baseTest } from '@playwright/test';
import fs from 'fs';
import path from 'path';
import crypto from 'crypto';

// 1. Exportamos 'expect' de forma directa para evitar el ciclo de Node.js
export { expect } from '@playwright/test';

// 2. Extendemos el test base de Playwright para automatizar la cobertura
export const test = baseTest.extend({
  context: async ({ context }, use) => {
    
    // Inyectamos el script para recolectar cobertura antes de cambiar de página
    await context.addInitScript(() =>
      window.addEventListener('beforeunload', () =>
        (window as any).collectIstanbulCoverage(JSON.stringify((window as any).__coverage__))
      ),
    );
    
    // Creamos la carpeta temporal
    await fs.promises.mkdir('tests/e2e/coverage-reports/.nyc_output', { recursive: true });
    
    // Exponemos la función a Node para guardar el archivo
    await context.exposeFunction('collectIstanbulCoverage', (coverageJSON: string) => {
      if (coverageJSON) {
        fs.writeFileSync(
          path.join('tests/e2e/coverage-reports/.nyc_output', `coverage_${crypto.randomUUID()}.json`), 
          coverageJSON
        );
      }
    });
    
    // Ejecutamos el test real
    await use(context);
    
    // Al terminar el test, extraemos la cobertura final
    for (const page of context.pages()) {
      await page.evaluate(() => 
        (window as any).collectIstanbulCoverage(JSON.stringify((window as any).__coverage__))
      );
    }
  }
});