<template>
  <div class="perimeter" />
</template>

<script>
/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

/* Ol/Ol-Ext */
import * as ol from "../Imports/ol";
import * as olExt from "../Imports/ol-ext";
import { fromLonLat } from "ol/proj";

export default {
  nameL: "VolPerimeter",

  data() {
    return {
      //perimeter: null,
    };
  },

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
    ...mapGetters({ perimeterCuts: "geoportal/developmentUnits" }),
  },

  methods: {
    ...mapActions({
      setMap: "geoportal/setMap",
      getPerimeter: "geoportal/getDevelopmentUnits",
    }),

    perimeter() {
      /* Iterate the features to print each perimeter */

      for (const feature of this.perimeterCuts.features) {
        var coords = [];
        for (const coordsWrapper of feature.geometry.coordinates) {
          for (const coord of coordsWrapper) {
            coords.push(fromLonLat([coord[1], coord[0]]))
          }
        }

        var f = new ol.Feature(new ol.Polygon([coords]));
        var vector = new ol.LayerVector({
          source: new ol.Vector({ features: [f] }),
          style: new ol.Style({
            stroke: new ol.Stroke({ width: 5, color: "blue" }),
            fill: new ol.Fill({ color: "red" }),
          }),
        });

        this.map.addLayer(vector);
      }

      // var coords = this.perimeterCuts.features[0].geometry.coordinates;

      // console.log("Coords", coords);

      // var f = new ol.Feature(new ol.Polygon(coords));
      // var vector = new ol.LayerVector({
      //   source: new ol.Vector({ features: [f] }),
      //   style: new ol.Style({
      //     stroke: new ol.Stroke({ width: 5, color: "blue" }),
      //     fill: new ol.Fill({ color: "red" }),
      //   }),
      // });

      // this.map.addLayer(vector);

      /* Update the stored map */
      this.setMap(this.map);
    },
  },

  watch: {
    volSideCommand: function (newVal, oldVal) {},
  },

  mounted() {
    console.log("ENTER");
    this.getPerimeter().then(() => {
      console.log("This perimeter: ", this.perimeterCuts);
      this.perimeter();
    });
  },
};
</script>