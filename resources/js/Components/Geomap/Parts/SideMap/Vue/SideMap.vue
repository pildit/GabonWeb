<template>
  <div>
    <v-map
      ref="map"
      :zoom="7"
      :maxZoom="16"
      :center="initialLocation"
      :style="{ height: window.height - 78 + 'px', width: '100%' }"
    >
      <v-icondefault></v-icondefault>
      <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
    </v-map>
  </div>
</template>

<script>
import * as Vue2Leaflet from "vue2-leaflet";
import { latLng, Icon, icon } from "leaflet";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";

import { EventBus } from "components/EventBus/EventBus";

/* Vuex */
import { mapGetters, mapActions } from "vuex";

import "leaflet-draw";
import "leaflet-draw/dist/leaflet.draw.css";

import transformation from "@pusky/transform-coordinates";
import { parse, stringify } from 'wellknown';

export default {
  components: {
    "v-map": Vue2Leaflet.LMap,
    "v-tilelayer": Vue2Leaflet.LTileLayer,
    "v-icondefault": Vue2Leaflet.LIconDefault,
    "v-marker": Vue2Leaflet.LMarker,
    "v-popup": Vue2Leaflet.LPopup,
  },

  props: ["endpointEdit", "endpointCreate"],

  data() {
    return {
      locations: [],
      icon: icon(
        Object.assign({}, Icon.Default.prototype.options, {
          iconUrl,
          shadowUrl,
        })
      ),
      clusterOptions: {
        chunkedLoading: true,
      },
      initialLocation: latLng(-0.803698, 11.609454),

      window: {
        width: window.innerWidth,
        height: window.innerHeight,
      },
      map: null,
      drawControl: null,
      perimeter: null,
      editableLayers: null,

      defaultDrawPluginOptions: {
        position: "topright",
        draw: {
          polygon: {
            allowIntersection: false, // Restricts shapes to simple polygons
            drawError: {
              color: "#e1e100", // Color the shape will turn when intersects
              message: "<strong>Oh snap!<strong> you can't draw that!", // Message that will show when intersect
            },
            shapeOptions: {
              color: "#97009c",
            },
          },
          // disable toolbar item by setting it to false
          // polygon: true,
          polyline: false,
          circle: false, // Turns off this drawing tool
          rectangle: false,
          marker: false,
          circlemarker: false,
        },
        edit: {
          featureGroup: null, //REQUIRED!!
          remove: true,
          edit: true,
          poly: {
            allowIntersection: false,
          },
        },
      },
    };
  },

  computed: {
    ...mapGetters({ permits: "geoportal/permits" }),
    ...mapGetters({
      annualAllowableCutInventory: "geoportal/annualAllowableCutInventory",
    }),
    ...mapGetters({ annualAllowableCuts: "geoportal/annualAllowableCuts" }),
    ...mapGetters({ parcelsPerimeters: "geoportal/parcels" }),
    ...mapGetters({ concessionsPerimeters: "geoportal/concessions" }),
    ...mapGetters({ developmentUnits: "geoportal/developmentUnits" }),
    ...mapGetters({ managementUnits: "geoportal/managmentUnits" }),
  },

  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },

  methods: {
    ...mapActions({
      getPermits: "geoportal/getPermits",
      getAnnualAllowableCutInventory:
        "geoportal/getAnnualAllowableCutInventory",
      getAnnualAllowableCuts: "geoportal/getAnnualAllowableCuts",
      getParcelsPerimeters: "geoportal/getParcelsVectors",
      getConcessionsPerimeters: "geoportal/getConcessions",
      getDevelopmentUnits: "geoportal/getDevelopmentUnits",
      getManagementUnits: "geoportal/getManagmentUnits",
    }),

    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },

    emitWkt() {
        const transform = transformation("EPSG:4326", "EPSG:5223");

        let latLngs = [];
        let i = 0;
        _.each(this.editableLayers._layers, (layer) => {
            latLngs[i] = []; latLngs[i][0] = [];
            _.each(layer._latlngs[0], (p) => {
                const {x , y} = transform.forward({
                    x: Number(p.lng),
                    y: Number(p.lat)
                })
                let newPoint = [x,y];
                latLngs[i][0].push(newPoint)
            })
            /* Add the last point yet again in order to have a closed perimeter */
            latLngs[i][0].push(latLngs[i][0][0]);
            i++;
        })

        let geojsonFeature = {};
        let wkt = null;
        if(latLngs.length) {
            geojsonFeature = {
                type: "Feature",
                geometry: {
                    type: "MultiPolygon",
                    coordinates: latLngs
                }
            }
            wkt = stringify(geojsonFeature);
        }

        return wkt;
    },

    initDrawPolygon() {
      let map = this.$refs.map.mapObject;

      var editableLayers = new L.FeatureGroup();
      this.editableLayers = editableLayers;
      map.addLayer(editableLayers);

      this.defaultDrawPluginOptions.edit.featureGroup = editableLayers;
      var drawPluginOptions = this.defaultDrawPluginOptions;

      // Initialise the draw control and pass it the FeatureGroup of editable layers
      this.drawControl = new L.Control.Draw(drawPluginOptions);
      map.addControl(this.drawControl);

      /* CREATED */
      map.on("draw:created", (e) => {
        var layer = e.layer;

        /* Delete old control */
        map.removeControl(this.drawControl);

        /* Create the new control */
        // drawPluginOptions.draw.polygon = false;
        this.drawControl = new L.Control.Draw(drawPluginOptions);
        map.addControl(this.drawControl);

        layer.bindPopup("Perimeter");
        this.editableLayers.addLayer(layer);
        EventBus.$emit(this.endpointCreate, this.emitWkt());
      });

      /* EDITED */
      map.on("draw:edited", (e) => {
        let layers = e.layers;
        map.addLayer(layers);
        EventBus.$emit(this.endpointCreate, this.emitWkt());
      });

      /* DELETE */
      map.on("draw:deleted", (e) => {
        layer = e.layer;

        /* Delete the perimeter from the current state */
        this.editableLayers.removeLayer(layer);
        EventBus.$emit(this.endpointCreate, this.emitWkt());


        /* Remove the old control */
        map.removeControl(this.drawControl);

        /* Create the new control */
        // drawPluginOptions.draw.polygon = true;
        this.drawControl = new L.Control.Draw(drawPluginOptions);
        map.addControl(this.drawControl);
      });
    },

    getStrPosition(string, subString, index) {
      return string.split(subString, index).join(subString).length;
    },
  },

  mounted() {
    window.addEventListener("resize", () => {
      this.window.height = window.innerHeight;
    });
    this.initDrawPolygon();

    EventBus.$on(this.endpointEdit, (data) => {
      console.log(parse(data));

      if (this.editableLayers === null) return;
      if (!data || data === "") return;

      data = parse(data);
      let latLngs = [];
      const transform = transformation("EPSG:5223", "EPSG:4326");
      data.coordinates.forEach((polyCoords, i) => {
          polyCoords.forEach((coords) => {
              latLngs[i] = [];
              coords.forEach((p) => {
                  const {x, y} = transform.forward({
                      x: Number(p[0]),
                      y: Number(p[1])
                  })
                  let newPoint = [y,x];
                  latLngs[i].push(newPoint)
              })
          });
      });

      /* Delete old control */
      let map = this.$refs.map.mapObject;

      map.removeLayer(this.editableLayers);
      var editableLayers = new L.FeatureGroup();
      this.editableLayers = editableLayers;
      map.addLayer(editableLayers);

        this.defaultDrawPluginOptions.edit.featureGroup = editableLayers;

      map.removeControl(this.drawControl);
      // this.defaultDrawPluginOptions.draw.polygon = false;
      this.drawControl = new L.Control.Draw(this.defaultDrawPluginOptions);
      map.addControl(this.drawControl);

      latLngs.forEach((coords) => {
          console.log(coords);
          L.polygon(coords).addTo(this.editableLayers)
      })
        map.fitBounds(this.editableLayers.getBounds());
    });
  },
};
</script>

<style>
@import "~leaflet/dist/leaflet.css";
@import "~leaflet.markercluster/dist/MarkerCluster.css";
@import "~leaflet.markercluster/dist/MarkerCluster.Default.css";
html,
body {
  height: 100%;
  margin: 0;
}
</style>
