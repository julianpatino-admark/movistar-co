"use strict";
import { Loader } from "@googlemaps/js-api-loader";

export default class {
  /*
   * Object with all google maps libraries
   * {@link https://developers.google.com/maps/documentation/javascript/libraries}
   **/
  GoogleClasses = {};

  /*
   * The google loader by javascript
   * {@link https://developers.google.com/maps/documentation/javascript/load-maps-js-api?hl=es-419#js-api-loader}
   **/
  loader;

  // Object with Map options if is needed to initialize
  mapObj;

  /*
   * Google map object
   * {@link https://developers.google.com/maps/documentation/javascript/reference/map}
   */
  map;

  /*
   * Html element with the map container
   */
  $mapContainer;

  /*
   * Html element with the input to fill with the address to search or autocomplete
   */
  $target;

  /*
   * The floating window element for maps
   * {@link https://developers.google.com/maps/documentation/javascript/reference/info-window}
   */
  infoWindow;

  /*
   * The floating marker icon element for maps
   * {@link https://developers.google.com/maps/documentation/javascript/reference/marker}
   */
  marker;

  /*
   * Object with the map positions with lat and lng keys
   */
  position;

  /**
   * Initialize libraries and class parameters
   * @param {string} key - Key with configured API
   * @param {Object[]|null} map - Object with initial configurations
   * @param {string} map.mapId - Key of configured map with his style
   * @param {Object} map.position - Initial position ex. {lat: 4.648, lng: -74.190}
   * @param {string[]} [libraries=["geocoding", "places", "maps", "marker"]] - Array with each needed key loader library
   */
  constructor({
    key,
    map= null,
    libraries= ["geocoding", "places", "maps", "marker"],
  }) {
    this.mapObj = map;
    this.libraries = libraries;
    this.loader = new Loader({
      libraries: this.libraries,
      apiKey: key,
      version: "weekly"
    });
  }

  /*
   * Initial load of each google maps library
   * @return {Promise}
   **/
  async load() {
    let getAllLibraries = await Promise.allSettled(this.libraries.map(a => this.loader.importLibrary(a)));
    this.GoogleClasses = getAllLibraries.reduce(
      (obj, { status, value }) =>
      {
        if (status === "fulfilled") return {...obj, ...value };
      },
      {}
    );
  }

  /**
   * Is used if is needed to create a new map and set his container
   * @param {string} containerId - The id of map container visualization
   */
  async initMap(containerId) {

    if (this.mapObj) {
      const { mapId, position } = this.mapObj;
      this.position = position;
      this.$mapContainer = document.getElementById(containerId);

      this.infoWindow = new this.GoogleClasses.InfoWindow();
      this.map = new this.GoogleClasses.Map(this.$mapContainer, {
        center: this.position,
        zoom: 10,
        mapId
      });
    } else {
      console.error("El objeto mapa no ha sido inicializado");
    }
  }

  /**
   * Add new Google Maps marker with dragging enable and push on current map
   * If marker is dragged, the position is updated and filled
   */
  async addMarker() {

    this.marker = new this.GoogleClasses.Marker({
      position: this.position,
      map: this.map,
      draggable: true
    });

    this.marker.addListener("dragend", async (event) => {
      this.position = this.marker.position;
      let { formatted_address } = await this.getAddress();
      this.$target.value = formatted_address;
    });
  }

  /**
   * initialize the [autocomplete]{@link https://developers.google.com/maps/documentation/javascript/reference/places-widget#Autocomplete} function of Google Maps
   * @param {HTMLInputElement} $targetEl - The input elemet to enable the autocomplete function
   */
  async initAutocompleteAddress($targetEl) {
    let autocomplete = new this.GoogleClasses.Autocomplete($targetEl, {
      componentRestrictions: { country: ["co"] },
      fields: ["formatted_address", "geometry"],
      types: ["address"],
    });

    autocomplete.bindTo("bounds", this.map);

    autocomplete.addListener("place_changed", () => {
      if(this.marker) {
        this.marker.setVisible(false);
      } else {
        this.addMarker();
      }
      this.infoWindow.close();

      const place = autocomplete.getPlace();

      if (!place.geometry || !place.geometry.location) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
      }

      if (place.geometry.viewport) {
        this.map.fitBounds(place.geometry.viewport);
      } else {
        this.map.setCenter(place.geometry.location);
        this.map.setZoom(17);
      }

      this.marker.setPosition(place.geometry.location);
      this.marker.setVisible(true);
    });
  }

  /**
   * - Fill the input with current position based on navigator location
   * - Add the InfoWindow with the formatted address
   * - Add the Marker on the spot based on the position
   * - Append a loader spinner at the end of anchor
   * @param {HTMLAnchorElement} $el - The anchor element who was clicked
   * @param {HTMLInputElement|null} [$target=null] - The input elemet to fill with current address
   */
  async setCurrentAddress($el, $target=null) {
    const isPosLoaded = await this.getCurrentBrowserPosition();
    if(!isPosLoaded) return false;

    const loader = document.createElement("div");
    loader.className = "select-loader";
    $el.appendChild(loader);

    if (this.map){
      this.map.setCenter(this.position);
      this.map.setZoom(17);
      await this.addMarker();
      this.$mapContainer.classList.add("open");
    }

    if($target) {
      let { formatted_address } = await this.getAddress();
      this.$target = $target
      this.$target.value = formatted_address;
    }
    $el.removeChild(loader);
  }

  /**
   * Get the current address based on lat and lang obj with [geocode]{@link https://developers.google.com/maps/documentation/javascript/reference/geocoder#Geocoder} funcion of google maps
   */
  async getAddress() {
    const geocoder = new this.GoogleClasses.Geocoder();

    try {
      let { results } = await geocoder.geocode({ location: this.position });
      let resultAddr = results.length > 0 ? results[0].formatted_address : "No results found";

      if (this.map && results[0]) {
        const Contenido = document.createElement("div");
        Contenido.className = "results";
        Contenido.innerHTML = results[0].formatted_address;

        this.infoWindow.setContent(Contenido);
        this.infoWindow.open(this.map, this.marker);

        return results[0];
      };

      return { formatted_address: resultAddr };
    } catch (err) {
      window.alert("Geocoder failed due to: " + err);
    }
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
        this.position = { lat: coords.latitude, lng: coords.longitude };
      } catch (err) {
        console.error(err);
        this.handleLocationError(true);
      }
    } else {
      // Browser doesn't support Geolocation
      this.handleLocationError(false);
    }
  }

  insertCobaltFields() {

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
