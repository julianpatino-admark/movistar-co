import InitGeolocalizacion from "./index";

function InitEvents (MapClass) {
  document.querySelectorAll("[data-set]").forEach((el) => {
    const { set, target=null, mapId = null } = el.dataset;

    if (set === "current-position") {
      const $targetEl = document.getElementById(target);
      el.addEventListener("click", () =>{
        if(mapId) MapClass.initMap(mapId);
        MapClass.setCurrentAddress(el, $targetEl);
      });
    }

    if (set === "autocomplete-address") {
      MapClass.initAutocompleteAddress(el);
    }
  })
}

function init(ParamsObj) {
  const Mapa = new InitGeolocalizacion(ParamsObj);
  Mapa.load().then(() => InitEvents(Mapa));
}

export default {
  init,
}