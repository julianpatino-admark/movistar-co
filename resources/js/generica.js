"use strict"

import "./setup";

/**
 * Modales
 */
import "./modules/modal/modal-init";
import "./modules/modal/modal-index";
import ModalShow from "admark-landings/src/modal/events/show.bs.modal";

/**
 * Analítica
 */
import CallMetrics from "admark-landings/src/analytics/callmetrics";

/**
 * Formularios
 */
import "jquery-validation/dist/localization/messages_es";
import "admark-landings/src/validation/lang/messages_es";

import "admark-landings/src/validation/phone";

import LocalForms from "./modules/forms/index";
import FormSimple from "admark-landings/src/forms/form-simple";
import ToggleEnabled from "admark-landings/src/forms/toggle-enabled";

/**
 * Buttons
 */
import { WppBtn } from "./modules/buttons/index";
WppBtn();

/**
 * Scroll
 */
import NavClose from "./modules/nav/nav-close";

/**
 * Slide
 */
import "./modules/carousel/index";

/**
 * INIT
 */
CallMetrics.init();
LocalForms.init();
FormSimple.init();
ToggleEnabled.init();
ModalShow.init();

NavClose.init();
