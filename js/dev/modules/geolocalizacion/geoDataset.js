function InitEvents (MapClass) {
  document.querySelectorAll("[data-set]").forEach((el) => {
    const { set } = el.dataset;

    if (set === "current-position") {
      el.addEventListener("click", () =>{
        MapClass.setCurrentAddress(el);
      });
    }

    if(set === "autocomplete-address") MapClass.initAutocompleteAddress(el);

    if(set === "fill-cobalt") MapClass.fillCobalt(el);

    if(set === "init-map") MapClass.initMap(el);
  })
}

function init(MapClass) {
  MapClass.load().then(() => InitEvents(MapClass));
}

export default {
  init,
  InitEvents
}