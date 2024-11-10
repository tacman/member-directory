import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['loading', 'map']
    // ...

  connect() {
    console.error(this.identifier);
    this.element.addEventListener('ux:map:marker:before-create', this._onMarkerBeforeCreate);
  }

  disconnect() {
    // Always remove listeners when the controller is disconnected
    this.element.removeEventListener('ux:map:marker:before-create', this._onMarkerBeforeCreate);
  }

  _onMarkerBeforeCreate(event) {
    // You can access the marker definition and the Leaflet object
    // Note: `definition.rawOptions` is the raw options object that will be passed to the `L.marker` constructor.
    const { definition, L } = event.detail;
    console.log(event);

    // Use a custom icon for the marker
    const redIcon = L.icon({
      // Note: instead of using an hardcoded URL, you can use the `extra` parameter from `new Marker()` (PHP) and access it here with `definition.extra`.
      iconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-red.png',
      shadowUrl: 'https://leafletjs.com/examples/custom-icons/leaf-shadow.png',
      iconSize: [38, 95], // size of the icon
      shadowSize: [50, 64], // size of the shadow
      iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
      shadowAnchor: [4, 62],  // the same for the shadow
      popupAnchor: [-3, -76] // point from which the popup should open relative to the iconAnchor
    })

    definition.rawOptions = {
      icon: redIcon,
    }
  }

}
