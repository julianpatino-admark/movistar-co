import MapLibreGL from "maplibre-gl";
import { MainMapClass } from "./MainMapClass";

export default class MapLibre extends MainMapClass {

  style = {
    version: 8,
    sources: {
      osm: {
        type: "raster",
        tiles: ["https://a.tile.openstreetmap.org/{z}/{x}/{y}.png"],
        tileSize: 256,
        attribution: "&copy; OpenStreetMap Contributors",
        maxzoom: 19
      }
    },
    layers: [
      {
        id: "osm",
        type: "raster",
        source: "osm"
      }
    ]
  };

  /**
   * Is used if is needed to create a new map and set his container
   * @param {HTMLDivElement} container - The main div container
   * @returns {Promise}
   */
  initMap(container) {
    const { setCenter = "4.6484639,-74.190207", setZoom = "12", target } = container.dataset;
    const MainStyle = document.createElement("link");
    MainStyle.rel = "stylesheet";
    MainStyle.href = "https://unpkg.com/maplibre-gl@3.2.0/dist/maplibre-gl.css";
    document.head.appendChild(MainStyle);
    this.$mapContainer = container;
    if (target) this.$TargetInput = document.getElementById(target);

    this.map = new MapLibreGL.Map({
      container,
      style: this.style,
      center: setCenter.split(","),
      zoom: setZoom,
    }).addControl(new MapLibreGL.NavigationControl());
  }

  /**
   * - Fill the input with current position based on navigator location
   * - Add the Popup window with the formatted address
   * - Add the Marker on the spot based on the position
   * - Append a loader spinner at the end of anchor
   * @param {HTMLAnchorElement} $el - The anchor element who was clicked
   */
  async setCurrentAddress($el){
    const { target } = $el.dataset;
    const loader = document.createElement("div");
    loader.className = "select-loader";
    $el.appendChild(loader);
    await this.getCurrentBrowserPosition();

    if (this.map){
      this.map.setCenter(this.position);
      this.map.setZoom(18);
      await this.addMarker();
      this.$mapContainer.classList.add("open");
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
        this.map.setCenter(this.position);
        if (this.marker) {
          this.marker.setLngLat(this.position);
        } else {
          this.addMarker();
        }

        let PopUp = new MapLibreGL.Popup({ closeOnClick: false }).setHTML(display_name);
        this.marker.setPopup(PopUp).togglePopup();
      }
    };

    $input.addEventListener("keydown", this.InitSearchEvent($input, onClick));
  }

  /**
   * Add new marker with dragging enable and push on current map
   * If marker is dragged, the position is updated and filled
   */
  async addMarker() {
    this.marker = new MapLibreGL.Marker({
      draggable: true
    })
      .setLngLat(this.position)
      .addTo(this.map);

    this.marker.on("dragend", async () => {
      this.position = this.marker.getLngLat();
      const { display_name } = await this.getAddress();
      let PopUp = new MapLibreGL.Popup({ closeOnClick: false }).setHTML(display_name);
      this.marker.setPopup(PopUp).togglePopup();
      this.$TargetInput.value = display_name;
    });
  }
}
