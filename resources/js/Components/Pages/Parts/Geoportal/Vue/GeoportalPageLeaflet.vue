<template>
  <div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="warningModal"
      ref="warningModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="ModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalLabel">
              {{ translate("Modal_Title") }}
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">{{ translate("Modal_Content") }}</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">
              {{ translate("Agree_Button") }}
            </button>
          </div>
        </div>
      </div>
    </div>

    <div>
      <div>
        <v-map-sidebar
          v-if="hideSidebar == false"
          :map="map"
          @onViewActiveTransports="executeOnActiveTransports($event)"
          @onCheckNone="executeOnCheckNone($event)"
          @onCheckPlateNumber="executeOnCheckPlateNumber($event)"
          @onCheckAACId="executeOnCheckAACId($event)"
          @onCheckAACName="executeOnCheckAACName($event)"
          @onCheckTransportPermitId="executeOnCheckTransportPermitId($event)"
          @onCheckTransportPermitDate="
            executeOnCheckTransportPermitDate($event)
          "
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
          :maxZoom="18"
          :center="initialLocation"
          :style="{ height: window.height - 78 + 'px', width: '100%' }"
        >
          <v-icondefault></v-icondefault>
          <v-tilelayer
            url="http://{s}.tile.osm.org/{z}/{x}/{y}.png"
          ></v-tilelayer>
          <v-marker-cluster
            :options="clusterOptions"
            @clusterclick="onTreeClusterClicked()"
            @ready="ready"
          >
            <!-- Check Transport Permit Id -->
            <v-marker
              v-for="l in dataCheckTransportPermitId"
              :key="l.id"
              :lat-lng="l.latlng"
              :icon="icon"
            >
              <v-popup :content="l.text"></v-popup>
            </v-marker>

            <!-- Check Transport Permit Date -->
            <v-marker
              v-for="l in dataCheckTransportPermitDate"
              :key="l.id"
              :lat-lng="l.latlng"
              :icon="icon"
            >
              <v-popup :content="l.text"></v-popup>
            </v-marker>

            <!-- View Trees -->
            <!-- <v-marker
          v-for="l in dataTrees"
          :key="l.id"
          :lat-lng="l.latlng"
          :icon="icon"
        >
          <v-popup :content="l.text"></v-popup>
        </v-marker> -->
          </v-marker-cluster>
        </v-map>
      </div>
    </div>
  </div>
</template>



<script>
import * as Vue2Leaflet from "vue2-leaflet";
import { latLng, Icon, icon } from "leaflet";
import Vue2LeafletMarkercluster from "./MapLeaflet/Vue2LeafletMarkercluster";
import MapSidebar from "./MapLeaflet/MapSidebar";
import iconUrl from "leaflet/dist/images/marker-icon.png";
import shadowUrl from "leaflet/dist/images/marker-shadow.png";
import iconRetinaUrl from "leaflet/dist/images/marker-icon-2x.png";

// import { PruneCluster, PruneClusterForLeaflet } from '../utilsPruneCluster'
// import '../utilsPruneCluster.css'

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

  props: ["hideSidebarProp", "endpointName"],

  data() {
    return {
      hideSidebar: false,
      annualAllowableCutId: "",
      annualAllowableCutName: "",
      annualAllowableCutNameId: "",
      renderParcels: false,
      renderConcessions: false,
      renderUFA: false,
      renderUFG: false,
      renderAAC: false,
      renderAnnualAllowableCut: false,
      renderTrees: false,
      renderConstituentPermits: false,
      renderTransportPermits: false,
      bbox: undefined,

      dataCheckPlateNumber: null,
      dataCheckAAC: null,
      dataCheckAACId: null,
      dataCheckAACName: null,
      dataCheckTransportPermitId: null,
      dataCheckTransportPermitDate: null,
      dataParcels: null,
      dataConcessions: null,
      dataUFA: null,
      dataUFG: null,
      dataViewAAC: null,
      dataTrees: null,
      activePermitFeatures: null,
      dataConstituentPermits: null,
      dataTransportPermits: null,

      treeMarkers: L.markerClusterGroup({
        chunkedLoading: true,
      }),

      permitMarkers: L.markerClusterGroup({
        chunkedLoading: true,
      }),

      transportPermitsMarkers: L.markerClusterGroup({
        chunkedLoading: true,
      }),

      activeTransportFeatureGroup: L.layerGroup({
        chunkedLoading: true,
      }),

      // treesPruneCluster: new PruneClusterForLeaflet(),

      featureHighlightColor: "#333333",

      colorAnnualAllowableCut: "#ff0013",
      colorParcels: "#34A34F",
      colorConcessions: "#7c00ff",
      colorClusters: "#0015ff",
      colorUFA: "#00c4ff",
      colorUFG: "#ebf30c",
      colorAAC: "#ff9b00",
      colorTrees: "#ff00c0",
      colorConstituentPermits: "#1f2bd1",

      locations: [],
      icon: icon(
        Object.assign({}, Icon.Default.prototype.options, {
          iconUrl,
          iconRetinaUrl,
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
    ...mapGetters({ permits: "geoportal/permits" }),
    ...mapGetters({
      annualAllowableCutInventory: "geoportal/annualAllowableCutInventory",
    }),
    ...mapGetters({ annualAllowableCuts: "geoportal/annualAllowableCuts" }),
    ...mapGetters({ parcelsPerimeters: "geoportal/parcels" }),
    ...mapGetters({ concessionsPerimeters: "geoportal/concessions" }),
    ...mapGetters({ developmentUnits: "geoportal/developmentUnits" }),
    ...mapGetters({ managementUnits: "geoportal/managmentUnits" }),
    ...mapGetters({ permitsTracking: "geoportal/permitsTracking" }),
    ...mapGetters({ constituentPermits: "geoportal/constituentPermits" }),
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
      getPermitsTracking: "geoportal/getPermitsTracking",
      getConstituentPermits: "geoportal/getConstituentPermits",
    }),

    onTreeClusterClicked: (e) => {
      // TODO: More possible features
      console.log("clusterclick", e);
    },
    ready: (e) => console.log("ready", e),

    getJSONToString(json) {
      const objectConstructor = {}.constructor;
      let resultedString = "";

      const jsonLenght = Object.keys(json).length;
      if (jsonLenght <= 0) return null; // Nothing to show

      let iterator = 0;
      Object.keys(json).forEach(function (key) {
        const value = json[key];
        let paramValue = value;

        if (value === undefined || value === null || !value) {
          return;
        }

        /* Look for arrays */
        if (Array.isArray(value)) {
          if (value.length <= 0) return;

          paramValue = value.join(",");
        }

        /* Look for other jsons */
        if (value.constructor === objectConstructor) {
          paramValue = this.getJSONToString(value);
        }

        resultedString += `${key}: ${paramValue}`;

        /* Prepare for the next parameter */
        if (++iterator < jsonLenght) {
          resultedString += "<br>";
        }
      });

      return resultedString;
    },

    openWarningModal() {
      $("#warningModal").modal("show");
    },

    onGetActiveTransports(endpointData, data, layerGroup) {
      if (!endpointData.features || endpointData.features.length == 0) {
        this.openWarningModal();
        this.cleanUpClusters(data, layerGroup, map);
        return;
      }

      /* Parse through the date in order to get their order ;) */
      let polyList = new Map();

      endpointData.features.forEach((element) => {
        const p = element.properties;
        const hashKey =
          p.LicensePlate +
          p.DriverName +
          p.PermitNo +
          p.Destination +
          p.Province;

        if (!polyList.has(hashKey)) {
          polyList.set(hashKey, []);
        }

        polyList.get(hashKey).push(element);
      });

      let map = this.$refs.map.mapObject;
      this.cleanUpClusters(data, layerGroup, map);

      let onEachFeature = (feature, layer) => {
        if (feature.properties) {
          const properties = this.getJSONToString(feature.properties);
          layer.bindPopup(properties);
        }
      };

      let myLayerOptions = {
        pointToLayer: this.createCustomIcon,
        onEachFeature: onEachFeature,
        // filter: onFilter,
      };

      // data = L.geoJson(polyList.get('dsftest nou20_30_AAC_5jjfd'), myLayerOptions);

      // polyList.get('dsftest nou20_30_AAC_5jjfd').forEach((feature) => {
      //   lanlngs.push([feature.geometry.coordinates[0], feature.geometry.coordinates[1]])
      // })

      polyList.forEach((value, key) => {
        let lanlngs = [];

        // let sorted = value.sort((e1, e2) => {
        //   let date1 = new Date(e1.properties.ObserveAt);
        //   let date2 = new Date(e2.properties.ObserveAt);

        //   return date1.getTime() - date2.getTime();
        // });

        value.forEach((feature) => {
          lanlngs.push([
            feature.geometry.coordinates[0],
            feature.geometry.coordinates[1],
          ]);
        });

        const generalizeProperties = () => {
          let polyProperties = value[0].properties;
          delete polyProperties.id;
          delete polyProperties.ObserveAt;

          return polyProperties;
        };

        L.polyline(lanlngs, {weight: 5, opacity: 0.8 })
          .bindPopup(this.getJSONToString(generalizeProperties()))
          .addTo(layerGroup); // PolyLine

        this.createCustomMarkerWithPopUp(
          value[0],
          [value[0].geometry.coordinates[0], value[0].geometry.coordinates[1]],
          "Source"
        ).addTo(layerGroup); // Source marker

        this.createCustomMarkerWithPopUp(
          value[value.length - 1],
          [
            value[value.length - 1].geometry.coordinates[0],
            value[value.length - 1].geometry.coordinates[1],
          ],
          "Destination"
        ).addTo(layerGroup); // Destination marker
      });

      // data = L.polyline(lanlngs);
      // layerGroup.addLayer(data);

      map.addLayer(layerGroup);

      // if (endpointData.features && endpointData.features.length > 0)
      //   map.fitBounds(markers.getBounds(), { padding: [200, 200] });
    },

    /* Execute methods */
    executeOnActiveTransports(value) {
      if (value) {
        this.getPermitsTracking().then(() => {
          this.onGetActiveTransports(
            this.permitsTracking,
            this.activePermitFeatures,
            this.activeTransportFeatureGroup
          );

          // L.geoJSON(geojsonFeature).addTo(map);
        });
      } else {
        if (this.activePermitFeatures) this.activePermitFeatures.remove();
        if (this.activeTransportFeatureGroup)
          this.activeTransportFeatureGroup.remove();
      }
    },

    executeOnCheckNone() {
      if (this.permitMarkers) {
        this.permitMarkers.remove();
        this.permitMarkers.clearLayers();
      }

      if (this.dataCheckAAC) this.dataCheckAAC.remove();

      if (this.dataCheckPlateNumber) {
        this.dataCheckPlateNumber.length = 0;
        this.dataCheckPlateNumber = null;
      }

      if (this.dataCheckTransportPermitId) {
        this.dataCheckTransportPermitId.length = 0;
        this.dataCheckTransportPermitId = null;
      }

      if (this.dataCheckTransportPermitDate) {
        this.dataCheckTransportPermitDate.length = 0;
        this.dataCheckTransportPermitDate = null;
      }
    },

    getTimeDateFormat(date) {
      let year = date.getFullYear().toString();
      let month = (date.getMonth() + 1).toString();
      let day = date.getDate().toString();
      let hours = date.getHours().toString();
      let minutes = date.getMinutes().toString();
      let seconds = date.getSeconds().toString();

      if (parseInt(month) < 10) month = "0" + month;
      if (parseInt(day) < 10) day = "0" + day;
      if (parseInt(hours) < 10) hours = "0" + hours;
      if (parseInt(minutes) < 10) minutes = "0" + minutes;
      if (parseInt(seconds) < 10) seconds = "0" + seconds;

      return (
        year +
        "-" +
        month +
        "-" +
        day +
        " " +
        hours +
        ":" +
        minutes +
        ":" +
        seconds
      );
    },

    executeOnCheckPlateNumber(value, params = null) {
      const { plateNumber, plateNumberRange } = value;
      let { start, end } = plateNumberRange;

      start.setHours(0);
      start.setMinutes(0);
      start.setSeconds(0);

      end.setHours(0);
      end.setMinutes(0);
      end.setSeconds(0);

      let startDate = this.getTimeDateFormat(start);
      let endDate = this.getTimeDateFormat(end);

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["LicensePlate"] = plateNumber;
      fParams["DateFrom"] = startDate;
      fParams["DateTo"] = endDate;

      this.getPermits(fParams).then(() => {
        if (this.dataCheckPlateNumber) this.dataCheckPlateNumber.length = 0;
        console.log("PERMITS:", this.permits);
        this.onGetCheckClusters(
          this.dataCheckPlateNumber,
          this.permits,
          this.permitMarkers
        );
      });
    },

    executeOnCheckAACId(value = "", params = null) {
      // If already renderded clean the old data and print the new one
      if (value === "") return;
      this.annualAllowableCutId = value;

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["Id"] = value;

      this.getAnnualAllowableCuts(fParams).then(() => {
        if (this.dataCheckAACId) this.dataCheckAACId.remove();
        if (this.dataCheckAAC) this.dataCheckAAC.remove();
        this.onGetCheckAAC();
      });
    },

    executeOnCheckAACName(value = "", params = null) {
      if (value === "") return;
      this.annualAllowableCutName = value;

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["Name"] = value;

      this.getAnnualAllowableCuts(fParams).then(() => {
        if (this.dataCheckAACName) this.dataCheckAACName.remove();
        this.onGetCheckAAC();
      });
    },

    executeOnCheckTransportPermitId(value, params = null) {
      const { hourInterval, permitId } = value;

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["PermitNo"] = permitId;

      this.getPermits(fParams).then(() => {
        if (this.dataCheckTransportPermitId)
          this.dataCheckTransportPermitId.length = 0;
        this.onGetCheckClusters(
          this.dataCheckTransportPermitId,
          this.permits,
          this.permitMarkers
        );
      });
    },

    executeOnCheckTransportPermitDate(value, params = null) {
      const { hourInterval, date } = value;
      const startHour = hourInterval[0];
      const endHour = hourInterval[1];

      let startDate = new Date(date);
      startDate.setHours(startHour);
      startDate.setMinutes(0);
      startDate.setSeconds(0);

      let endDate = new Date(date);
      endDate.setHours(endHour);
      endDate.setMinutes(0);
      endDate.setSeconds(0);

      let fParams = params;
      if (!fParams) fParams = {};
      fParams["DateFrom"] = this.getTimeDateFormat(startDate);
      fParams["DateTo"] = this.getTimeDateFormat(endDate);

      this.getPermits(fParams).then(() => {
        if (this.dataCheckTransportPermitDate)
          this.dataCheckTransportPermitDate.length = 0;
        this.onGetCheckClusters(
          this.dataCheckTransportPermitDate,
          this.permits,
          this.permitMarkers
        );
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

    createCustomIcon(feature, latlng) {
      let iconOptions = Icon.Default.prototype.options;
      iconOptions.iconUrl = iconUrl;
      iconOptions.shadowUrl = shadowUrl;
      iconOptions.iconRetinaUrl = iconRetinaUrl;
      let myIcon = L.icon(iconOptions);
      return L.marker(latlng, { icon: myIcon });
    },

    createCustomMarkerWithPopUp(feature, latlng, popupTitle = "") {
      return this.createCustomIcon(feature, latlng).bindPopup(
        `<h5>${popupTitle}</h5>` + this.getJSONToString(feature.properties)
      );
    },

    onGetTrees() {
      this.onGetCheckClusters(
        this.dataTrees,
        this.annualAllowableCutInventory,
        this.treeMarkers,
        false // TODO: Fix fitBounds not working for getTrees
      );

      // TODO - Possible prune cluster implementation
      // let localPruneCluster = this.treesPruneCluster;
      // localPruneCluster.Cluster.Size = 160;
      // localPruneCluster.PrepareLeafletMarker = function (leafletMarker, data) {
      //   // leafletMarker.bindPopup(data.properties.name);
      //   // leafletMarker.on("click", function (evt) {
      //   //   console.log(data);
      //   // });
      // };

      // this.dataTrees = L.geoJSON(this.annualAllowableCutInventory, {
      //   pointToLayer: function (feature, latLng) {
      //     var marker = new PruneCluster.Marker(latLng.lat, latLng.lng);
      //     marker.data.properties = feature.properties;
      //     localPruneCluster.RegisterMarker(marker);
      //   },
      // });

      // map.addLayer(localPruneCluster);
    },

    onGetTransportPermits() {
      this.onGetCheckClusters(
        this.dataTransportPermits,
        this.permits,
        this.transportPermitsMarkers,
        false // TODO: Fix fitBounds not working for getTransportPermits
      );
    },

    executeOnViewTrees(value, params = null) {
      this.renderTrees = value;

      if (value) {
        this.getAnnualAllowableCutInventory(params).then(() => {
          this.onGetTrees();
        });
      } else {
        if (this.dataTrees) this.dataTrees.remove();
        if (this.treeMarkers) this.treeMarkers.remove();
      }
    },

    executeOnViewTransportPermits(value, params = null) {
      this.renderTransportPermits = value;

      if (value) {
        this.getPermits(params).then(() => {
          this.onGetTransportPermits();
        });
      } else {
        if (this.dataTransportPermits) this.dataTransportPermits.remove();
        if (this.transportPermitsMarkers) this.transportPermitsMarkers.remove();
      }
    },

    executeOnViewConstituentPermits(value, params = null) {
      this.renderConstituentPermits = value;

      if (value) {
        this.getConstituentPermits(params).then(() => {
          if (this.dataConstituentPermits) this.dataConstituentPermits.remove();
          if (!this.renderConstituentPermits) return;
          this.onGetConstituentPermits();
        });
      } else if (this.dataConstituentPermits) {
        this.dataConstituentPermits.remove();
      }
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

      const queryBbox = {
        bbox: undefined,
      }; // TODO

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

      /* Get Constituent Permits */
      if (this.renderConstituentPermits) {
        this.executeOnViewConstituentPermits(
          this.renderConstituentPermits,
          queryBbox
        );
      }

      /* Get Transport Permits */
      if (this.renderTransportPermits) {
        this.executeOnViewTransportPermits(
          this.renderTransportPermits,
          queryBbox
        );
      }

      /* Set the new Bbox */
      this.bbox = currentBounds;

      // this.getAnnualAllowableCutInventory({
      //   bbox: [northEast.lat, northEast.lng, southWest.lat, southWest.lng],
      // }).then(() => {
      //   this.clusterSetup(this.annualAllowableCutInventory);
      // });
    },

    cleanUpClusters(data, markers, map = null) {
      if (markers) {
        markers.remove();
        markers.clearLayers();
      }
      if (data) data.remove();

      if (map) {
        map.removeLayer(markers);
      }
    },

    /* PLATE NUMBER */
    onGetCheckClusters(data, endpointData, markers, fitBounds = true) {
      if (!endpointData.features || endpointData.features.length == 0) {
        this.openWarningModal();
      }

      /* Clean-up of previous data */
      this.cleanUpClusters(data, markers);

      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
        }
      };

      let myLayerOptions = {
        pointToLayer: this.createCustomIcon,
        onEachFeature: onEachFeature,
      };

      data = L.geoJson(endpointData, myLayerOptions);

      markers.addLayer(data);
      map.addLayer(markers);

      if (endpointData.features && endpointData.features.length > 0)
        map.fitBounds(markers.getBounds(), { padding: [200, 200] });
    },

    /* ANNUAL ALLOWABLE CUT */
    onGetCheckAAC() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
        }
      };

      this.dataCheckAAC = L.geoJSON(this.annualAllowableCuts, {
        style: (feature) => {
          return {
            color: this.colorAnnualAllowableCut,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataCheckAAC.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataCheckAAC.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        /* Bounds fitting */
        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });

      const bounds = this.dataCheckAAC.getBounds();
      map.fitBounds(bounds, { padding: [200, 200] });

      this.dataCheckAAC.addTo(map);
    },

    /* CONSTITUENT PERMITS */
    onGetConstituentPermits() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
        }
      };

      this.dataConstituentPermits = L.geoJSON(this.constituentPermits, {
        style: (feature) => {
          return {
            color: this.colorConstituentPermits,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataConstituentPermits.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataConstituentPermits.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });
      this.dataConstituentPermits.addTo(map);
    },

    /* PARCELS */
    onGetParcels() {
      let map = this.$refs.map.mapObject;

      let onEachFeature = (feature, layer) => {
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
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
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
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

        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
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
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
        }
      };

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
        if (feature.properties) {
          layer.bindPopup(this.getJSONToString(feature.properties));
        }
      };

      this.dataViewAAC = L.geoJSON(this.annualAllowableCuts, {
        style: (feature) => {
          return {
            color: this.colorAAC,
          };
        },
        onEachFeature: onEachFeature,
      });

      this.dataViewAAC.on("click", (event) => {
        const prevStyleColor = event.layer.options.color;
        this.dataViewAAC.resetStyle();

        if (prevStyleColor !== this.featureHighlightColor)
          event.layer.setStyle({ color: this.featureHighlightColor });

        /* Bounds fitting */
        const bounds = event.layer.getBounds();
        map.fitBounds(bounds, { padding: [200, 200] });
      });

      this.dataViewAAC.addTo(map);
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
    },
  },

  mounted() {
    /* On move end event */
    let map = this.$refs.map.mapObject;
    this.map = map;

    map.on("moveend", this.onMoveEnd);
    // map.addLayer(this.treeMarkers);

    // map.on("zoomend", this.onMoveEnd);

    window.addEventListener("resize", () => {
      this.window.height = window.innerHeight;
    });

    if (this.hideSidebarProp === "true") this.hideSidebar = true;
    else this.hideSidebar = false;

    switch (this.endpointName) {
      case "development-unit": {
        this.renderUFA = true;
        break;
      }

      case "management-unit": {
        this.renderUFG = true;
        break;
      }

      case "aac-grid": {
        this.renderAAC = true;
        break;
      }

      case "aac-inventory": {
        this.renderTrees = true;
        break;
      }

      case "parcels": {
        this.renderParcels = true;
        break;
      }

      case "constituent-permit": {
        this.renderConstituentPermits = true;
        break;
      }

      case "concessions": {
        this.renderConcessions = true;
        break;
      }

      case "transport-permits": {
        this.renderTransportPermits = true;
        break;
      }

      default:
        break;
    }

    /* Load concessions and others based on the current zoom level */
    this.onMoveEnd();
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
