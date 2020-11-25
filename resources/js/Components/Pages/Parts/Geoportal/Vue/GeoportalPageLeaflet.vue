<template>
  <div>
    <v-map-sidebar
      :map="map"
      @onCheckNone="executeOnCheckNone($event)"
      @onCheckAAC="executeOnCheckAAC($event)"
      @onViewParcels="executeOnViewParcels($event)"
      @onViewConcessions="executeOnViewConcessions($event)"
      @onViewUFA="executeOnViewUFA($event)"
      @onViewUFG="executeOnViewUFG($event)"
      @onViewAAC="executeOnViewAAC($event)"
      @onViewTrees="executeOnViewTrees($event)"
    ></v-map-sidebar>

    <v-map
      ref="map"
      :zoom="7"
      :center="initialLocation"
      :style="{ height: window.height - 78 + 'px', width: '100%' }"
    >
      <v-icondefault></v-icondefault>
      <v-tilelayer url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"></v-tilelayer>
      <v-marker-cluster
        :options="clusterOptions"
        @clusterclick="onTreeClusterClicked()"
        @ready="ready"
      >
        <v-marker
          v-for="l in dataTrees"
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
      annualAllowableCutNameId: "",
      renderParcels: false,
      renderConcessions: false,
      renderUFA: false,
      renderUFG: false,
      renderAAC: false,
      renderTrees: false,
      bbox: undefined,

      dataCheckAAC: null,
      dataParcels: null,
      dataConcessions: null,
      dataUFA: null,
      dataUFG: null,
      dataViewAAC: null,
      dataTrees: [],

      featureHighlightColor: "#333333",

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
      clusterOptions: {
        chunkedLoading: true,
      },
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

    onTreeClusterClicked: (e) => {
      // TODO: More possible features
      console.log("clusterclick", e);
    },
    ready: (e) => console.log("ready", e),

    /* Execute methods */
    executeOnCheckNone() {
      console.log("CHECK NONE");
      if (this.dataCheckAAC) this.dataCheckAAC.remove();
      // TODO: Add PLATE_NUMBER and TRANSPORT_PERMIT
    },

    executeOnCheckAAC(value = "", params = null) {
      if (value === "") return;
      this.annualAllowableCutNameId = value;

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["Name"] = value;

      this.getAnnualAllowableCuts(fParams).then(() => {
        if (this.dataCheckAAC) this.dataCheckAAC.remove();
        this.onGetCheckAAC();
      });
    },

    executeOnViewParcels(value, params = null) {
      this.renderParcels = value;

      if (value) {
        this.getParcelsPerimeters(params).then(() => {
          if (this.dataParcels) this.dataParcels.remove();
          if (!this.renderParcels) return;
          this.onGetParcels();
        });
      } else if (this.dataParcels) {
        this.dataParcels.remove();
      }
    },

    executeOnViewConcessions(value, params = null) {
      this.renderConcessions = value;

      if (value) {
        this.getConcessionsPerimeters(params).then(() => {
          if (this.dataConcessions) this.dataConcessions.remove();
          if (!this.renderConcessions) return;
          this.onGetConcessions();
        });
      } else if (this.dataConcessions) {
        this.dataConcessions.remove();
      }
    },

    executeOnViewUFA(value, params = null) {
      this.renderUFA = value;

      if (value) {
        this.getDevelopmentUnits(params).then(() => {
          if (this.dataUFA) this.dataUFA.remove();
          if (!this.renderUFA) return;
          this.onGetUFA();
        });
      } else if (this.dataUFA) {
        this.dataUFA.remove();
      }
    },

    executeOnViewUFG(value, params = null) {
      this.renderUFG = value;

      if (value) {
        this.getManagementUnits(params).then(() => {
          if (this.dataUFG) this.dataUFG.remove();
          if (!this.renderUFG) return;
          this.onGetUFG();
        });
      } else if (this.dataUFG) {
        this.dataUFG.remove();
      }
    },

    executeOnViewAAC(value, params = null) {
      this.renderAAC = value;

      if (value) {
        this.getAnnualAllowableCuts(params).then(() => {
          if (this.dataViewAAC) this.dataViewAAC.remove();
          if (!this.renderAAC) return;
          this.onGetViewAAC();
        });
      } else if (this.dataViewAAC) {
        this.dataViewAAC.remove();
      }
    },

    executeOnViewTrees(value, params = null) {
      this.renderTrees = value;

      if (value) {
        this.getAnnualAllowableCutInventory(params).then(() => {
          if (this.dataTrees.length > 0) this.dataTrees = [];
          if (!this.renderTrees) return;
          this.onGetTrees();
        });
      } else if (this.dataTrees.length > 0) {
        this.dataTrees = [];
      }
    },

    /* Render methods */
    onGetTrees() {
      let points = this.annualAllowableCutInventory;

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
      this.dataTrees = locations;
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

      const queryBbox = [
        currentNorthEast.lat,
        currentNorthEast.lng,
        currentSouthWest.lat,
        currentSouthWest.lng,
      ];

      // const queryBbox = {
      //   bbox: undefined,
      // }; // TODO

      /* Get AnnualAllowableCut */
      if (this.renderAnnualAllowableCut) {
        this.executeOnCheckAAC(this.annualAllowableCutNameId, queryBbox);
      }

      /* Get parcels */
      if (this.renderParcels) {
        this.executeOnViewParcels(this.renderParcels, queryBbox);
      }

      /* Get concessions */
      if (this.renderConcessions) {
        this.executeOnViewConcessions(this.renderConcessions, queryBbox);
      }

      /* Get UFA */
      if (this.renderUFA) {
        this.executeOnViewUFA(this.renderUFA, queryBbox);
      }

      /* Get UFG */
      if (this.renderUFG) {
        this.executeOnViewUFG(this.renderUFG, queryBbox);
      }

      /* Get AAC */
      if (this.renderAAC) {
        this.executeOnViewAAC(this.renderAAC, queryBbox);
      }

      /* Get Trees */
      if (this.renderTrees) {
        this.executeOnViewTrees(this.renderTrees, queryBbox);
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

      this.dataCheckAAC = L.geoJSON(this.annualAllowableCuts, {
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

      this.dataParcels = L.geoJSON(this.parcelsPerimeters, {
        style: (feature) => {
          return {
            color: this.colorParcels,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataParcels.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataParcels.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });
      this.dataParcels.addTo(map);
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

      this.dataConcessions = L.geoJSON(this.concessionsPerimeters, {
        style: (feature) => {
          return {
            color: this.colorConcessions,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataConcessions.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataConcessions.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });
      this.dataConcessions.addTo(map);
    },

    /* UFA */
    onGetUFA() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        // /* Bind click event */
        // layer.on({
        //   click: this.onUFAClicked,
        // });

        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("UFA Id:" + feature.properties.id));
        }
      };

      this.dataUFA = L.geoJSON(this.developmentUnits, {
        style: (feature) => {
          return {
            color: this.colorUFA,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataUFA.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataUFA.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });
      this.dataUFA.addTo(map);
    },

    /* UFG */
    onGetUFG() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("UFG Id:" + feature.properties.id));
        }
      };

      console.log(this.managementUnits);
      this.dataUFG = L.geoJSON(this.managementUnits, {
        style: (feature) => {
          return {
            color: this.colorUFG,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataUFG.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataUFG.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        /* Bounds fitting */
        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });

      this.dataUFG.addTo(map);
    },

    /* AAC */
    onGetViewAAC() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        /* Bind click event */
        layer.on({
          click: () => this.onFeatureClicked(layer),
        });

        if (feature.properties && feature.properties.id) {
          layer.bindPopup(this.translate("AAC Id:" + feature.properties.id));
        }
      };

      this.dataViewAAC = L.geoJSON(this.annualAllowableCuts, {
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