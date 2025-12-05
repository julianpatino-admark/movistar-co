import * as LeafMaps from "leaflet";
import { MainMapClass } from "./MainMapClass";
import MapLibreGL from "maplibre-gl";

export default class LeafLetMaps extends MainMapClass {

  /**
   * Is used if is needed to create a new map and set his container
   * @param {HTMLDivElement} container - The main div container
   */
  async initMap(container) {
    const { setCenter = "4.6484639,-74.190207", setZoom = "12", target } = container.dataset;

    const LeafStyle = document.createElement("link");
    LeafStyle.rel = "stylesheet";
    LeafStyle.href = "https://unpkg.com/leaflet@1.9.4/dist/leaflet.css";
    LeafStyle.integrity = "sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=";
    LeafStyle.crossOrigin = "";
    document.head.appendChild(LeafStyle);
    if (target) this.$TargetInput = document.getElementById(target);

    container.classList.add("open");
    await new Promise(resolve => setTimeout(resolve, 500));

    this.map = LeafMaps.map(container, {
      center: setCenter.split(","),
      zoom: setZoom,
      maxZoom: 18,
    });

    LeafMaps.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      detectRetina: true,
      maxZoom: 19
    }).addTo(this.map);
  }

  /**
   * - Fill the input with current position based on navigator location
   * - Add the Popup window with the formatted address
   * - Add the Marker on the spot based on the position
   * - Append a loader spinner at the end of anchor
   * @param {HTMLAnchorElement} $el - The anchor element who was clicked
   */
  async setCurrentAddress($el) {
    const { target } = $el.dataset;
    const loader = document.createElement("div");
    loader.className = "select-loader";
    $el.appendChild(loader);
    await this.getCurrentBrowserPosition();

    if (this.map) {
      this.map.flyTo(this.position, 18);
      await this.addMarker();
    }

    if(target) {
      const $target = document.getElementById(target);
      let { display_name } = await this.getAddress();
      $target.value = display_name;
    }

    $el.removeChild(loader);
  }

  /**
   * initialize the [autocomplete]{@link hhttps://nominatim.org/release-docs/develop/api/Search/#search-queries} with Nominatim API
   * @param {HTMLInputElement} $input - The input field to fill with the address text
   */
  initAutocompleteAddress($input) {
    let onClick = ({ geometry, display_name }) => {
      this.position = {
        lng: geometry.coordinates[0],
        lat: geometry.coordinates[1],
      };
      if(this.map) {
        this.map.panTo(this.position);
        if (this.marker) {
          this.marker.setLatLng(this.position);
        } else {
          this.addMarker();
        }
        this.marker.setPopupContent(display_name);
      }
    };

    $input.addEventListener("keydown", this.InitSearchEvent($input, onClick));
  }

  /**
   * Add new marker with dragging enable and push on current map
   * If marker is dragged, the position is updated and filled
   */
  async addMarker() {
    this.marker = LeafMaps.marker(this.position, {
      draggable: true,
    }).addTo(this.map);
    const { display_name } = await this.getAddress();
    this.marker
      .bindPopup(display_name)
      .openPopup();

    this.marker.on("dragend", async () => {
      this.position = this.marker.getLatLng();
      const { display_name } = await this.getAddress();
      this.marker.setPopupContent(display_name).openPopup();
      this.$TargetInput.value = display_name;
    });
  }
}
