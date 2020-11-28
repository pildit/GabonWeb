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
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

import "leaflet-draw";
import "leaflet-draw/dist/leaflet.draw.css";

export default {
  components: {
    "v-map": Vue2Leaflet.LMap,
    "v-tilelayer": Vue2Leaflet.LTileLayer,
    "v-icondefault": Vue2Leaflet.LIconDefault,
    "v-marker": Vue2Leaflet.LMarker,
    "v-popup": Vue2Leaflet.LPopup,
  },

  props: ["endpointName"],

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

    emitEndpoint(data) {
      let iterator = 0;
      const l = data[0].length;
      let geometryForm = "POLYGON((";
      data[0].forEach((latLong) => {
        console.log(latLong);
        geometryForm += latLong.lat + " " + latLong.lng;
        if (++iterator < l) {
          geometryForm += ",";
        }
      });

      geometryForm += "))";
      return geometryForm;
    },

    initDrawPolygon() {
      let map = this.$refs.map.mapObject;

      var editableLayers = new L.FeatureGroup();
      map.addLayer(editableLayers);

      var drawPluginOptions = {
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
          polygon: true,
          polyline: false,
          circle: false, // Turns off this drawing tool
          rectangle: false,
          marker: false,
          circlemarker: false,
        },
        edit: {
          featureGroup: editableLayers, //REQUIRED!!
          remove: true,
          edit: true,
          poly: {
            allowIntersection: false,
          },
        },
      };

      var savePerimeter = (perimeter) => {
        this.perimeter = perimeter;
        EventBus.$emit(this.endpointName, this.emitEndpoint(perimeter));
      };

      var deletePerimeter = () => {
        this.perimeter = null;
        EventBus.$emit(this.endpointName, "");
      };

      // Initialise the draw control and pass it the FeatureGroup of editable layers
      var drawControl = new L.Control.Draw(drawPluginOptions);
      map.addControl(drawControl);

      /* CREATED */
      map.on("draw:created", function (e) {
        var layer = e.layer;
        var type = e.layerType;

        /* Save the perimeter to the current state */
        savePerimeter(layer._latlngs);

        /* Delete old control */
        map.removeControl(drawControl);

        /* Create the new control */
        drawPluginOptions.draw.polygon = false;
        drawControl = new L.Control.Draw(drawPluginOptions);
        map.addControl(drawControl);

        layer.bindPopup("Perimeter");
        editableLayers.addLayer(layer);
      });

      /* EDITED */
      map.on("draw:edited", function (e) {
        let layers = e.layers;

        layers.eachLayer(function (layer) {
          savePerimeter(layer._latlngs);
        });

        map.addLayer(layers);
      });

      /* DELETE */
      map.on("draw:deleted", function (e) {
        var type = e.layerType,
          layer = e.layer;

        /* Delete the perimeter from the current state */
        deletePerimeter();

        /* Remove the old control */
        map.removeControl(drawControl);

        /* Create the new control */
        drawPluginOptions.draw.polygon = true;
        drawControl = new L.Control.Draw(drawPluginOptions);
        map.addControl(drawControl);
      });
    },
  },

  mounted() {
    window.addEventListener("resize", () => {
      this.window.height = window.innerHeight;
    });
    this.initDrawPolygon();
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