export default function (map) {
  document.querySelectorAll("[data-set]").forEach((el) => {
    const { set, target=null } = el.dataset;

    if (set === "current-position") {
      const $targetEl = document.getElementById(target);
      el.addEventListener("click", () =>{
        map.setCurrentAddress(el, $targetEl);
      });
    }

    if (set === "autocomplete-address") {
      map.initAutocompleteAddress(el);
    }
  })
}