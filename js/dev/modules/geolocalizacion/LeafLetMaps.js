import * as LeafMaps from "leaflet";
import { debounce as _debounce } from "lodash";

export default class {

  /*
   * Google map object
   * {@link https://developers.google.com/maps/documentation/javascript/reference/map}
   */
  map;

  /*
   * The floating marker icon element for maps
   * {@link https://developers.google.com/maps/documentation/javascript/reference/marker}
   */
  marker;

  /*
   * Object with the map positions with lat and lng keys
   */
  position;

  constructor() {}

  initMap(containerId) {
    const LeafStyle = document.createElement("link");
    LeafStyle.rel = "stylesheet";
    LeafStyle.href = "https://unpkg.com/leaflet@1.9.4/dist/leaflet.css";
    LeafStyle.integrity = "sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=";
    LeafStyle.crossOrigin = "";
    document.head.appendChild(LeafStyle);

    this.map = LeafMaps.map(containerId, {
      center: [4.648, -74.190],
      zoom: 10
    });

    LeafMaps.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(this.map);

    console.log("Antes de return");
    return new Promise((resolve, reject) => this.map.on("load", resolve()));

  }

  /**
   * - Fill the input with current position based on navigator location
   * - Add the InfoWindow with the formatted address
   * - Add the Marker on the spot based on the position
   * - Append a loader spinner at the end of anchor
   * @param {HTMLAnchorElement} $el - The anchor element who was clicked
   * @param {HTMLInputElement|null} [$target=null] - The input elemet to fill with current address
   */
  async setCurrentAddress($el, $target=null){
    await this.getCurrentBrowserPosition();

    if (this.map){
      this.map.setView(this.position, 17);
      await this.addMarker();
    }

    if($target) {
      let { display_name } = await this.getAddress();
      this.$target = $target;
      this.$target.value = display_name;
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
   * initialize the [autocomplete]{@link https://developers.google.com/maps/documentation/javascript/reference/places-widget#Autocomplete} function of Google Maps
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

        await this.getCurrentBrowserPosition();
        const { address } = await this.getAddress();
        console.log(address);

        let queryObj = {
          q: $targetEl.value,
          format: "json",
          addresdetails: "1",
          limit: 4,
          city: address.city,
          country: address.country,
        };
        let res = await fetch(
          "https://nominatim.openstreetmap.org/search?" +
            new URLSearchParams(queryObj)
        ).then((res) => res.json());

        if(res.length > 0) this.createAutocomplete(res, $targetEl);
      },
      300,
      {
        leading: true,
        trailing: false,
      });

    $targetEl.addEventListener("keydown", searchBox);
  }

  /**
   * Add new Google Maps marker with dragging enable and push on current map
   * If marker is dragged, the position is updated and filled
   */
  async addMarker() {

    this.marker = LeafMaps.marker(this.position, {
      draggable: true
    }).addTo(this.map);
    this.marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();
    this.marker.on("dragend", (event) => {
      this.position = this.marker.getLatLng();
      this.getAddress();
    });
  }

  /**
   * Get the current address based on lat and lang obj with [geocode]{@link https://developers.google.com/maps/documentation/javascript/reference/geocoder#Geocoder} funcion of google maps
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
    sibling.insertAdjacentElement('afterend', Container);
  }
}