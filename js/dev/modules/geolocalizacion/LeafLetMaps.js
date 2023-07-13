import LeafMaps from "leaflet";

export default class {

  /*
   * Google map object
   * {@link https://developers.google.com/maps/documentation/javascript/reference/map}
   */
  map;

  /*
   * Object with the map positions with lat and lng keys
   */
  position;

  constructor() {}

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

  async setCurrentAddress(){
    await this.getCurrentBrowserPosition();

    console.debug(this.map);
    this.map.setView([this.position.lat, this.position.lng], 17);
  }
}