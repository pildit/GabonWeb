import { Map, View } from 'ol'
import OSM from "ol/source/OSM";
import Stamen from 'ol/source/Stamen'
import TileLayer from "ol/layer/Tile";
import Group from 'ol/layer/Group';
import Tile from 'ol/layer/Tile';
import LayerSwitcher from 'ol-ext/control/LayerSwitcher'
import { fromLonLat } from "ol/proj";

/* Helper function to parametrize strings */
export function getParametrizedString(apiString, payload) {

    const filters = payload
    const filterLenght = Object.keys(filters).length

    if (filterLenght <= 0)
        return apiString

    apiString += '?'
    let iterator = 0
    Object.keys(filters).forEach(function (key) {

        const value = filters[key]
        apiString += `${key}=${value}`

        /* Prepare for the next parameter */
        ++iterator < filterLenght ? apiString += '&' : null
    });

    return apiString
}

/* Open Layers helper functions */
export var baseLayers = new Group({
    title: 'Gabon Base layers',
    openInLayerSwicher: true,
    layers: [
        // adding a background tiled layer
        new TileLayer({
            title: 'OpenStreetMaps',
            baseLayer: true,
            source: new OSM(), // tiles are served by OpenStreetMap
        }),

        new TileLayer({
            title: 'Stamen',
            visible: false,
            source: new Stamen({ layer: 'toner' }), // tiles are served by OpenStreetMap
        }),
    ],
})

// Add control inside the map
export var baseControl = new LayerSwitcher();

// An overlay that stay on top
export var labels = new Tile({
    title: "Labels (on top)",
    allwaysOnTop: true,			// Stay on top of layer switcher
    noSwitcherDelete: true,		// Prevent deleting from layer switcher
    source: new Stamen({ layer: 'terrain-labels' })
  });
