"use strict";
import { Loader } from "@googlemaps/js-api-loader";

function getPosition(options = {}) {
  return new Promise((resolve, reject) =>
    navigator.geolocation.getCurrentPosition(resolve, reject, options)
  );
}

export default class {

  GoogleClasses = {
    Autocomplete: {},
    AdvancedMarkerElement: {},
    Geocoder: {}
  }

  loader;

  map;

  $mapContainer;

  mapId;

  infoWindow;

  position;

  marker;

  $target;

  constructor({ key, mapContainerId, mapId, position }) {
    this.position = position;
    this.$mapContainer = document.getElementById(mapContainerId);
    this.mapId = mapId;
    this.libraries = ["geocoding", "places", "maps", "marker"];
    this.loader = new Loader({
      libraries: this.libraries,
      apiKey: key,
      version: "weekly"
    });
  }

  async initMap() {
    await this.loader.load();
    let getAllLibraries = await Promise.allSettled(this.libraries.map(a => google.maps.importLibrary(a)));
    this.GoogleClasses = getAllLibraries.reduce(
      (obj, { status, value }) =>
      {
        if (status === "fulfilled") return {...obj, ...value };
      },
      {}
    );

    this.infoWindow = new this.GoogleClasses.InfoWindow();
    this.map = new this.GoogleClasses.Map(this.$mapContainer, {
      center: this.position,
      zoom: 10,
      mapId: this.mapId
    });
  }

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

  async initAutocompleteAddress($targetEl) {
    const { Autocomplete } = await google.maps.importLibrary("places");
    let autocomplete = new Autocomplete($targetEl, {
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

      console.log(this.marker);
      this.marker.setPosition(place.geometry.location);
      this.marker.setVisible(true);
    });
  }

  async setCurrentAddress($el, $target=null) {
    const loader = document.createElement("div");
    loader.className = "select-loader";

    $el.appendChild(loader);
    await this.getCurrentBrowserPosition();
    this.map.setCenter(this.position);
    this.map.setZoom(17);
    await this.addMarker();
    this.$mapContainer.classList.add("open");
    $el.removeChild(loader);

    if($target) {
      let { formatted_address } = await this.getAddress();
      this.$target = $target
      this.$target.value = formatted_address;
    }
  }

  async getAddress() {
    const geocoder = new this.GoogleClasses.Geocoder();

    try {
      let { results } = await geocoder.geocode({ location: this.position });

      if (results[0]) {
        const Contenido = document.createElement("div");
        Contenido.className = "results";
        Contenido.innerHTML = results[0].formatted_address;

        this.infoWindow.setContent(Contenido);
        this.infoWindow.open(this.map, this.marker);

        return results[0];
      } else {
        window.alert("No results found");
      }
    } catch (err) {
      window.alert("Geocoder failed due to: " + err);
    }
  }

  async getCurrentBrowserPosition() {
    if (navigator.geolocation) {
      try {
        const { coords } = await getPosition();
        this.position = { lat: coords.latitude, lng: coords.longitude };
      } catch (err) {
        this.handleLocationError(true);
      }
    } else {
      // Browser doesn't support Geolocation
      this.handleLocationError(false);
    }
  }

  handleLocationError(browserHasGeolocation) {
    this.infoWindow.setPosition(this.position);
    this.infoWindow.setContent(
      browserHasGeolocation
        ? "Error: The Geolocation service failed."
        : "Error: Your browser doesn't support geolocation."
    );
    this.infoWindow.open(this.map);
  }
}
