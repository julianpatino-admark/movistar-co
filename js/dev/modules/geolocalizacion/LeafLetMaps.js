import * as LeafMaps from "leaflet";
import { debounce as _debounce } from "lodash";

export default class {

  /*
   * leaflet map object
   * {@link https://leafletjs.com/reference.html#map}
   */
  map;

  /*
   * The floating marker icon element for maps
   * {@link https://leafletjs.com/reference.html#marker}
   */
  marker;

  /*
   * Html element with the map container
   */
  $mapContainer;

  /*
   * Object with the map positions with lat and lng keys
   */
  position;

  constructor() {}

  /**
   * Is used if is needed to create a new map and set his container
   * @param {string} containerId - The id of map container visualization
   */
  initMap(containerId) {
    const LeafStyle = document.createElement("link");
    LeafStyle.rel = "stylesheet";
    LeafStyle.href = "https://unpkg.com/leaflet@1.9.4/dist/leaflet.css";
    LeafStyle.integrity = "sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=";
    LeafStyle.crossOrigin = "";
    document.head.appendChild(LeafStyle);
    this.$mapContainer = document.getElementById(containerId);

    this.map = LeafMaps.map(containerId, {
      center: [4.648, -74.190],
      zoom: 10
    });

    LeafMaps.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(this.map);

    return new Promise((resolve, reject) => this.map.on("load", resolve()));

  }

  /**
   * - Fill the input with current position based on navigator location
   * - Add the Popup window with the formatted address
   * - Add the Marker on the spot based on the position
   * - Append a loader spinner at the end of anchor
   * @param {HTMLAnchorElement} $el - The anchor element who was clicked
   * @param {HTMLInputElement|null} [$target=null] - The input element to fill with current address
   */
  async setCurrentAddress($el, $target=null){
    const loader = document.createElement("div");
    loader.className = "select-loader";
    $el.appendChild(loader);
    await this.getCurrentBrowserPosition();

    if (this.map){
      this.map.setView(this.position, 17);
      await this.addMarker();
      this.$mapContainer.classList.add("open");
    }

    if($target) {
      let { display_name } = await this.getAddress();
      this.$target = $target;
      this.$target.value = display_name;
    }

    $el.removeChild(loader);
  }

  /**
   * Get the current position based on navigator [doc]{@link https://developer.mozilla.org/en-US/docs/Web/API/Geolocation_API}
   */
  async getCurrentBrowserPosition() {
    if (navigator.geolocation) {
      try {
        const { coords } = await new Promise((resolve, reject) =>
          navigator.geolocation.getCurrentPosition(resolve, reject)
        );
        this.position = {lat: coords.latitude, lng: coords.longitude};
      } catch (err) {
        console.error(err);
        this.handleLocationError(true);
      }
    } else {
      // Browser doesn't support Geolocation
      this.handleLocationError(false);
    }
  }

  /**
   * initialize the [autocomplete]{@link hhttps://nominatim.org/release-docs/develop/api/Search/#search-queries} with Nominatim API
   * @param {HTMLInputElement} $targetEl - The input elemet to enable the autocomplete function
   */
  initAutocompleteAddress($targetEl) {
    const searchBox = _debounce(
      async () => {
        if(this.map) {
          if (this.marker) {
            this.marker.unbindPopup();
            this.marker.remove();
          } else {
            this.addMarker();
          }
        }

        if(!this.position) await this.getCurrentBrowserPosition();

        let queryObj = {
          q: $targetEl.value,
          limit: 4,
          lat: this.position.lat,
          lon: this.position.lng
        };
        const { features } = await fetch(
          "https://photon.komoot.io/api/?" +
            new URLSearchParams(queryObj)
        ).then((res) => res.json());
        let opts = [];

        if(features.length > 0) {
          opts = features.map(({ properties, geometry}) => ({
            display_name: `${properties.name} ${properties.housenumber ? "# " + properties.housenumber : ""}, ${properties.city}, ${properties.state} - ${properties.country}`,
            properties,
            geometry
          }));
          console.log(opts);
        } else {
          opts.push({ display_name: "No se encontrado resultados"});
        }

        this.createAutocomplete(opts, $targetEl);
      },
      200,
      {
        leading: true,
        trailing: false,
      });

    $targetEl.addEventListener("keydown", searchBox);
  }

  /**
   * Add new marker with dragging enable and push on current map
   * If marker is dragged, the position is updated and filled
   */
  async addMarker() {

    this.marker = LeafMaps.marker(this.position, {
      draggable: true
    }).addTo(this.map);
    this.marker.bindPopup("<b>Soy una ventana informativa</b><br>Aquí verás la ubicación").openPopup();
    this.marker.on("dragend", (event) => {
      this.position = this.marker.getLatLng();
      this.getAddress();
    });
  }

  /**
   * Get the current address based on lat and lang obj with [geocode]{@link https://nominatim.org/release-docs/develop/api/Reverse/#reverse-geocoding} Nominatim API
   */
  async getAddress() {

    try {
      let queryObj = {
        lat: this.position.lat,
        lon: this.position.lng,
        format: "json",
        addresdetails: "1",
      };
      let res = await fetch(
        "https://nominatim.openstreetmap.org/reverse?" +
          new URLSearchParams(queryObj)
      ).then((res) => res.json());

      if (this.map && res) {
        this.marker.unbindPopup();
        this.marker.bindPopup(`${res.display_name}`).openPopup();
        this.marker.setLatLng(this.position);
      };

      return res;

    } catch (err) {
      window.alert("Geocoder failed due to: " + err);
    }
  }

  /**
   * Create an autocomplete list with autocomplete-results class on it
   * Each item of the list has a display_name
   * @param {object[]} options - The geocode addresses given by Nominatim
   * @param {HTMLInputElement|null} sibling - The current input element to append the autocomplete
   */
  createAutocomplete(options, sibling) {
    const PrevNode = sibling.parentNode.querySelector("#autocomplete-results");
    if(PrevNode) PrevNode.remove();

    const Container = document.createElement("ul");
    for (const option of options) {
      const Item = document.createElement("li");
      Item.innerText = option.display_name;
      Item.addEventListener("click", () => {
        sibling.value = option.display_name;
        Container.remove();
      });
      Container.appendChild(Item);
    }
    Container.id = "autocomplete-results";
    Container.classList.add("autocomplete-results");
    sibling.insertAdjacentElement("afterend", Container);
  }

  /**
   * Display window alert on error
   */
  handleLocationError(browserHasGeolocation) {
    if (browserHasGeolocation) {
      alert("La ubicación actual no pudo ser obtenida por el navegador.");
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  }
}