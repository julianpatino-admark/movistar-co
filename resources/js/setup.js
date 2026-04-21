/* istanbul ignore file */
import $ from 'jquery';

// Asignar a global INMEDIATAMENTE
window.$ = window.jQuery = $;

// Importar plugins que dependen de que jQuery ya sea global
import "bootstrap/js/dist/util.js";
import "bootstrap/js/dist/collapse.js";
import "jquery-validation";
import "jquery-validation/dist/localization/messages_es";

console.log('Setup global cargado: jQuery está listo.');