import { debounce as _debounce } from "lodash";

export class MainMapClass {
  /*
   * leaflet map object
   */
  map;

  /*
   * The floating marker icon element for maps
   */
  marker;

  /*
   * Html element with the map container
   */
  $TargetInput;

  /*
   * Object with the map positions with lat and lng keys
   */
  position;

  /*
   * Html element with the map container
   */
  $mapContainer;

  /*
   * Object with the address elements like city, state, country and more needed info
   */
  addrObject = {};

  /*
   * Object with the map positions with lat and lng keys
   */
  cobaltFieldExist = false;

  /*
   * Object with the map positions with lat and lng keys
   */
  cobaltFiledsKeys = {
    pais: { key: "GeoPais", selector: null },
    cuidad: { key: "GeoCiudad", selector: null },
    provincia: { key: "GeoProvincia", selector: null },
    calle: { key: "GeoCalle", selector: null },
    numero: { key: "GeoNumero", selector: null },
    region: { key: "GeoRegion", selector: null },
    latlng: { key: "GeoLatLng", selector: null },
  };
  load() {
    return new Promise((resolve, reject) =>
      this.map.on("load", () => resolve())
    );
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
  InitSearchEvent($input, callback) {
    return _debounce(
      async () => {
        if (!this.position) await this.getCurrentBrowserPosition();

        let queryObj = {
          q: this.$TargetInput.value,
          limit: 4,
          lat: this.position.lat,
          lon: this.position.lng,
        };
        const { features } = await fetch(
          "https://photon.komoot.io/api/?" + new URLSearchParams(queryObj)
        ).then((res) => res.json());
        let opts = [];

        if (features.length > 0) {
          opts = features.map(({ properties, geometry }) => ({
            display_name: `${
              properties.type == "house" ? properties.street : properties.name
            } ${properties.housenumber ? "# " + properties.housenumber : ""}, ${
              properties.city
            }, ${properties.state} - ${properties.country}`,
            properties,
            geometry,
          }));
        } else {
          opts.push({ display_name: "No se encontrado resultados" });
        }

        this.createAutocomplete(opts, callback);
      },
      300,
      {
        leading: true,
        trailing: false,
      }
    );
  }

  /**
   * Create an autocomplete list with autocomplete-results class on it
   * Each item of the list has a display_name
   * @param {object[]} options - The geocode addresses given by Nominatim
   * @param {function} callback - The current input element to append the autocomplete
   */
  createAutocomplete(options, callback) {
    const PrevNode = this.$TargetInput.parentNode.querySelector("#autocomplete-results");
    if (PrevNode) PrevNode.remove();

    const Container = document.createElement("ul");
    for (const option of options) {
      const Item = document.createElement("li");
      Item.innerText = option.display_name;
      Item.addEventListener("click", () => {
        this.$TargetInput.value = option.display_name;
        this.position = option.geometry.coordinates;
        this.addrObject = option;
        this.fillCobalt();

        callback(option);
        Container.remove();
      });
      Container.appendChild(Item);
    }
    Container.id = "autocomplete-results";
    Container.classList.add("autocomplete-results");
    this.$TargetInput.insertAdjacentElement("afterend", Container);
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

  fillCobalt(el = null) {
    if (!this.cobaltFieldExist) {
      for (const field in this.cobaltFiledsKeys) {
        let fieldKey = this.cobaltFiledsKeys[field].key;
        let inptEle = document.createElement("input");
        inptEle.type = "hidden";
        inptEle.name = fieldKey;
        inptEle.id = `${fieldKey}-${el.id}`;
        el.insertAdjacentElement("afterbegin", inptEle);
        this.cobaltFiledsKeys[field].selector = inptEle;
      }
      this.cobaltFieldExist = true;
    }

    if (this.addrObject.hasOwnProperty("properties")) {
      const { geometry, properties } = this.addrObject;
      const { country, state, city, name, street, housenumber, county } =
        properties;
      const { coordinates } = geometry;

      this.cobaltFiledsKeys.pais.selector.value = country;
      this.cobaltFiledsKeys.provincia.selector.value = state;
      this.cobaltFiledsKeys.cuidad.selector.value = city;
      this.cobaltFiledsKeys.calle.selector.value = street || name;
      this.cobaltFiledsKeys.numero.selector.value = housenumber;
      this.cobaltFiledsKeys.region.selector.value = county;
      this.cobaltFiledsKeys.latlng.selector.value = coordinates.toString();
    } else if (this.addrObject.hasOwnProperty("address")) {
      const { lat, lon, address } = this.addrObject;
      const { country, state, town, road, house_number, region } = address;

      this.cobaltFiledsKeys.pais.selector.value = country;
      this.cobaltFiledsKeys.provincia.selector.value = state;
      this.cobaltFiledsKeys.cuidad.selector.value = town;
      this.cobaltFiledsKeys.calle.selector.value = road;
      this.cobaltFiledsKeys.numero.selector.value = house_number;
      this.cobaltFiledsKeys.region.selector.value = region;
      this.cobaltFiledsKeys.latlng.selector.value = `${lon},${lat}`;
    }
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
      ).then((response) => response.json());

      this.addrObject = res;
      this.fillCobalt();
      return res;
    } catch (err) {
      window.alert("Geocoder failed due to: " + err);
    }
  }
}
