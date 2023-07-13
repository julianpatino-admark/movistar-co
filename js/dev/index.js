"use strict"

/**
 * jQuery Global
 */
import $ from 'jquery';
window.jQuery = $;
window.$ = $;

/**
 * Plugins jQuery
 */
import "bootstrap/js/dist/util.js";
import "bootstrap/js/dist/modal.js";
import "bootstrap/js/dist/collapse.js";
import "bootstrap/js/dist/carousel.js";

import "jquery-validation";
import "jquery-validation/dist/localization/messages_es";

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
import RGPD from "admark-landings/src/analytics/cookies-rgpd-gtm";
import RgpdHTML from 'admark-landings/src/analytics/cookies-rgpd-gtm-html'
import CookiesList from "./modules/cookies/cookies-list";

/**
 * Formularios
 */
import "jquery-validation/dist/localization/messages_es";
import "admark-landings/src/validation/lang/messages_es";

import "admark-landings/src/validation/phone";

import LocalForms from "./modules/forms/index";
import FormSimple from "admark-landings/src/forms/form-simple";
import EnableFields from "admark-landings/src/forms/enable-fields";
import ToggleEnabled from "admark-landings/src/forms/toggle-enabled";

/**
 * Buttons
 */
import WppBtn from "./modules/buttons/index";
WppBtn();

/**
 * Scroll
 */
import Sticky from "admark-landings/src/scroll/sticky";
import ScrollSlide from "admark-landings/src/scroll/slide";
import NavClose from "./modules/nav/nav-close";

/**
 * Google Map Geolocalizacion
 */
import Geolocalizacion from "./modules/geolocalizacion/geoDataset";

Geolocalizacion.init({
  key: "AIzaSyBkRwt18r6rRUEnnAu9zUBMvgIZJoBvfdg",
  map: {
    mapId: "3e1f8c1e0e9a9a40",
    position:{lat: 4.648, lng: -74.190},
  },
});

/**
 * INIT
 */
CallMetrics.init();
RGPD.init(
  CookiesList,
  RgpdHTML
);

LocalForms.init();
FormSimple.init();
EnableFields.init();
ToggleEnabled.init();
ModalShow.init();

Sticky.init();
ScrollSlide.init();

NavClose.init();

