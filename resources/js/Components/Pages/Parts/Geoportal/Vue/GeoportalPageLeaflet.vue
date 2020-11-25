<template>
  <div>
    <v-map-sidebar :map="map"></v-map-sidebar>

    <v-map
      ref="map"
      :zoom="7"
      :center="initialLocation"
      :style="{ height: window.height + 'px', width: '100%' }"
    >
      <v-icondefault></v-icondefault>
      <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
      <v-marker-cluster
        :options="clusterOptions"
        @clusterclick="click()"
        @ready="ready"
      >
        <v-marker
          v-for="l in locations"
          :key="l.id"
          :lat-lng="l.latlng"
          :icon="icon"
        >
          <v-popup :content="translate(l.text)"></v-popup>
        </v-marker>
      </v-marker-cluster>
    </v-map>
  </div>
</template>

<script>
import * as Vue2Leaflet from "vue2-leaflet";
import { latLng, Icon, icon } from "leaflet";
import Vue2LeafletMarkercluster from "./MapLeaflet/Vue2LeafletMarkercluster";
import MapSidebar from "./MapLeaflet/MapSidebar";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

function rand(n) {
  let max = n + 0.1;
  let min = n - 0.1;
  return Math.random() * (max - min) + min;
}

export default {
  components: {
    "v-map": Vue2Leaflet.LMap,
    "v-tilelayer": Vue2Leaflet.LTileLayer,
    "v-icondefault": Vue2Leaflet.LIconDefault,
    "v-marker": Vue2Leaflet.LMarker,
    "v-popup": Vue2Leaflet.LPopup,
    "v-marker-cluster": Vue2LeafletMarkercluster,
    "v-map-sidebar": MapSidebar,
  },

  data() {
    return {
      renderAnnualAllowableCut: false,
      renderParcels: false,
      renderConcessions: false,
      renderClusters: false,
      renderUFA: false,
      renderUFG: false,
      renderAAC: false,
      renderTrees: false,
      bbox: undefined,

      dataCheckAAC: null,
      dataViewAAC: null,

      colorAnnualAllowableCut: "#ff0013",
      colorParcels: "#34A34F",
      colorConcessions: "#7c00ff",
      colorClusters: "#0015ff",
      colorUFA: "#00c4ff",
      colorUFG: "#ebf30c",
      colorAAC: "#ff9b00",
      colorTrees: "#ff00c0",

      locations: [],
      icon: icon(
        Object.assign({}, Icon.Default.prototype.options, {
          iconUrl,
          shadowUrl,
        })
      ),
      clusterOptions: {},
      initialLocation: latLng(-0.803698, 11.609454),

      window: {
        width: window.innerWidth,
        height: window.innerHeight,
      },
      map: null,
    };
  },

  computed: {
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
      getAnnualAllowableCutInventory:
        "geoportal/getAnnualAllowableCutInventory",
      getAnnualAllowableCuts: "geoportal/getAnnualAllowableCuts",
      getParcelsPerimeters: "geoportal/getParcelsVectors",
      getConcessionsPerimeters: "geoportal/getConcessions",
      getDevelopmentUnits: "geoportal/getDevelopmentUnits",
      getManagementUnits: "geoportal/getManagmentUnits",
    }),

    click: (e) => console.log("clusterclick", e),
    ready: (e) => console.log("ready", e),

    clusterSetup(points) {
      var len;
      if (points.length == 0) {
        len = 0;
      } else {
        len = points.features.length;
      }

      let locations = [];
      for (var i = 0; i < len; ++i) {
        let latitude = points.features[i].geometry.coordinates[0];
        let longitude = points.features[i].geometry.coordinates[1];

        locations.push({
          id: i,
          latlng: latLng(latitude, longitude),
          text: "Point " + i,
        });
      }
      this.locations = locations;
    },

    onMoveEnd() {
      /* Get the map ref */
      let map = this.$refs.map.mapObject;

      /* Get the bounds */
      const currentBounds = map.getBounds();
      const currentNorthEast = currentBounds._northEast;
      const currentSouthWest = currentBounds._southWest;

      /* Previous state */
      const prevBbox = this.bbox;

      if (prevBbox !== undefined) {
        /* Is our new bbox contained in our old one? */
        if (prevBbox.contains(currentBounds)) {
          /* Skip updating anything else bbox related */
          return;
        }
      }

      // const queryBbox = [
      //   currentNorthEast.lat,
      //   currentNorthEast.lng,
      //   currentSouthWest.lat,
      //   currentSouthWest.lng,
      // ];

      const queryBbox = undefined; // TODO

      console.log("QueryBbox", queryBbox);

      /* Get AnnualAllowableCut */
      if (this.renderAnnualAllowableCut) {
        this.getAnnualAllowableCuts({ Name: "AAC2015" }).then(() => {
          this.onGetCheckAAC();
        });
      }

      /* Get concessions */
      if (this.renderConcessions) {
        this.getConcessionsPerimeters({
          bbox: queryBbox,
        }).then(() => {
          this.onGetConcessions();
        });
      }

      /* Get parcels */
      if (this.renderParcels) {
        this.getParcelsPerimeters({
          bbox: queryBbox,
        }).then(() => {
          this.onGetParcels();
        });
      }

      /* Get UFA */
      if (this.renderUFA) {
        this.getDevelopmentUnits().then(() => {
          this.onGetUFA();
        });
      }

      /* Get UFG */
      if (this.renderUFG) {
        this.getManagementUnits().then(() => {
          this.onGetUFG();
        });
      }

      /* Get AAC */
      if (this.renderAAC) {
        this.getAnnualAllowableCuts().then(() => {
          this.onGetViewAAC();
        });
      }

      /* Get Trees */
      if (this.renderTrees) {
        this.getAnnualAllowableCutInventory({
          bbox: queryBbox,
        }).then(() => {
          this.clusterSetup(this.annualAllowableCutInventory);
        });
      }

      /* Set the new Bbox */
      this.bbox = currentBounds;

      // this.getAnnualAllowableCutInventory({
      //   bbox: [northEast.lat, northEast.lng, southWest.lat, southWest.lng],
      // }).then(() => {
      //   this.clusterSetup(this.annualAllowableCutInventory);
      // });
    },

    /* ANNUAL ALLOWABLE CUT */
    onGetCheckAAC() {
      let map = this.$refs.map.mapObject;
      this.dataCheckAAC = this.annualAllowableCuts;

      let onEachFeature = (feature, layer) => {
        if (
          feature.properties &&
          feature.properties.id &&
          feature.properties.Name
        ) {
          layer.bindPopup(
            this.translate("Id: " + feature.properties.id) +
              " " +
              this.translate("Name: " + feature.properties.Name)
          );
        }
      };

      L.geoJSON(this.dataCheckAAC, {
        style: (feature) => {
          return {
            color: this.colorAnnualAllowableCut,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* PARCELS */
    onGetParcels() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("Id: " + feature.properties.id));
        }
      };

      L.geoJSON(this.parcelsPerimeters, {
        style: (feature) => {
          return {
            color: this.colorParcels,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* CONCESSIONS */
    onGetConcessions() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(
            this.translate("Concession Id:" + feature.properties.id)
          );
        }
      };

      L.geoJSON(this.concessionsPerimeters, {
        style: (feature) => {
          return {
            color: this.colorConcessions,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* UFA */
    onGetUFA() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("UFA Id:" + feature.properties.id));
        }
      };

      L.geoJSON(this.developmentUnits, {
        style: (feature) => {
          return {
            color: this.colorUFA,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* UFG */
    onGetUFG() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("UFG Id:" + feature.properties.id));
        }
      };

      L.geoJSON(this.managementUnits, {
        style: (feature) => {
          return {
            color: this.colorUFG,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* AAC */
    onGetViewAAC() {
      let map = this.$refs.map.mapObject;
      this.dataViewAAC = this.annualAllowableCuts;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("AAC Id:" + feature.properties.id));
        }
      };

      L.geoJSON(this.dataViewAAC, {
        style: (feature) => {
          return {
            color: this.colorAAC,
          };
        },
        onEachFeature: onEachFeature,
      }).addTo(map);
    },

    /* TREES */
    // onGetTrees() {
    //   let map = this.$refs.map.mapObject;

    //   let onEachFeature = (feature, layer) => {
    //     if (feature.properties && feature.properties.id) {
    //       layer.bindPopup(this.translate("Tree Id:" + feature.properties.id));
    //     }
    //   };

    //   L.geoJSON(this.annualAllowableCutInventory, {
    //     style: (feature) => {
    //       return {
    //         color: this.colorAAC,
    //       };
    //     },
    //     onEachFeature: onEachFeature,
    //   }).addTo(map);
    // },

    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;

      console.log("MODIFY: ", this.window.width, " x ", this.window.height);
    },
  },

  mounted() {
    /* On move end event */
    let map = this.$refs.map.mapObject;
    this.map = map;
    map.on("moveend", this.onMoveEnd);
    // map.on("zoomend", this.onMoveEnd);

    /* Load concessions and others based on the current zoom level */
    this.onMoveEnd();

    window.addEventListener("resize", () => {
      this.window.height = window.innerHeight;
    });
  },
};
</script>

<style>
@import "~leaflet/dist/leaflet.css";
@import "~leaflet.markercluster/dist/MarkerCluster.css";
@import "~leaflet.markercluster/dist/MarkerCluster.Default.css";
@import "./Imports/leaflet-sidebar.css";
html,
body {
  height: 100%;
  margin: 0;
}
</style>