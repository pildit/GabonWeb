<template>
  <v-map :zoom="7" :center="initialLocation" style="height: 750px; width: 100%">
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
        <v-popup :content="l.text"></v-popup>
      </v-marker>
    </v-marker-cluster>
  </v-map>
</template>

<script>
import * as Vue2Leaflet from "vue2-leaflet";
import { latLng, Icon, icon } from "leaflet";
import Vue2LeafletMarkercluster from "./MapLeaflet/Vue2LeafletMarkercluster";
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
  },

  data() {
    return {
      locations: [],
      icon: icon(
        Object.assign({}, Icon.Default.prototype.options, {
          iconUrl,
          shadowUrl,
        })
      ),
      clusterOptions: {},
      initialLocation: latLng(-0.803698, 11.609454),
    };
  },

  computed: {
    ...mapGetters({ points: "geoportal/annualAllowableCutInventory" }),
  },

  methods: {
    ...mapActions({
      getPoints: "geoportal/getAnnualAllowableCutInventory",
    }),

    click: (e) => console.log("clusterclick", e),
    ready: (e) => console.log("ready", e),

    clusterSetup() {
      var len;
      if (this.points.length == 0) {
        len = 0;
      } else {
        len = this.points.features.length;
      }
      console.log(this.points.features);

      let locations = [];
      for (var i = 0; i < len; ++i) {
        let latitude = this.points.features[i].geometry.coordinates[0];
        let longitude = this.points.features[i].geometry.coordinates[1];

        locations.push({
          id: i,
          latlng: latLng(latitude, longitude),
          text: "Hola " + i,
        });
      }
      this.locations = locations;
    },
  },

  mounted() {
    setTimeout(() => {
      console.log("done");
      this.$nextTick(() => {
        this.clusterOptions = { disableClusteringAtZoom: 11 };
      });
    }, 5000);

    this.getPoints().then(() => {
      this.clusterSetup();
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