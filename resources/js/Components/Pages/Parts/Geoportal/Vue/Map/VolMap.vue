<template>
  <div>
    <div
      id="map"
      class="map"
      ref="map-root"
      v-bind:style="{ height: window.height + 'px' }"
    ></div>

    <div class="options"></div>
  </div>
</template>

<script>
import TileLayer from "ol/layer/Tile";
import { toStringHDMS } from "ol/coordinate";
import { fromLonLat } from "ol/proj";

import OSM from "ol/source/OSM";
// importing the OpenLayers stylesheet is required for having
// good looking buttons!
import "ol/ol.css";
import "ol-ext/style/defaultStyle";

import olExtAnimatedCluster from "ol-ext/layer/AnimatedCluster";
import olCluster from "ol/source/Cluster";
import olVector from "ol/source/Vector";
import olFeature from "ol/Feature";
import olGeomPoint from "ol/geom/Point";
import olGeomPolygon from "ol/geom/Polygon";
import olView from "ol/View";
import olExtSelectCluster from "ol-ext/interaction/SelectCluster";
import olExtOverlay from "ol-ext/control/Overlay";
import olExtToggle from "ol-ext/control/Toggle";
import * as olCoordinate from "ol/coordinate/";
import * as olStyle from "ol/style";
// import * as olStyle from "ol-ext/style";

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";
import * as ol from "ol";

export default {
  name: "VolMap",

  data() {
    return {
      // map: null,
      // map: {
      //   ...mapState("geoportal", ["map"]),
      // },
      zoom: 2,
      center: [0, 0],
      rotation: 0,
      windowHeight: this.windowHeight,
      window: {
        width: 0,
        height: 0,
      },
    };
  },

  mutations: {},

  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },

  computed: {
    ...mapGetters({map: "geoportal/map"}),

    // ...mapMutations({
    //   setMap: "geoportal/map",
    // }),
  },

  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },

  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },

    ...mapActions({
      setMap: 'geoportal/setMap'
    })
  },

  mounted() {
    window.addEventListener("resize", () => {
      this.windowHeight = window.innerHeight;
    });

    this.map.setTarget(this.$refs["map-root"])
    this.setMap(this.map); // = this.$refs["map-root"];
    console.log(this.setMap);

    // 

    // this is where we create the OpenLayers map
    //const gabon_coord = fromLonLat([11.609454, -0.803698]);

    // var map = new ol.Map({
    //   // the map will be created using the 'map-root' ref
    //   target: this.$refs["map-root"],
    //   layers: [
    //     // adding a background tiled layer
    //     new TileLayer({
    //       source: new OSM(), // tiles are served by OpenStreetMap
    //     }),
    //   ],

    //   //the map view will initially show the whole world
    //   view: new ol.View({
    //     zoom: 7,
    //     center: gabon_coord,
    //     constrainResolution: true,
    //   }),
    // });

    // this.map = map;
  },
};
</script>
