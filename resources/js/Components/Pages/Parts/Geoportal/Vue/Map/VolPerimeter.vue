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

import Select from "ol/interaction/Select";
import { singleClick } from "ol/events/condition";

export default {
  name: "VolPerimeter",

  props: ["volViewParcels", "volViewConcessions"],

  data() {
    return {
      //perimeter: null,
      parcelsVectors: [],
      concessionsVectors: [],
    };
  },

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
    ...mapGetters({ perimeterCuts: "geoportal/developmentUnits" }),
    ...mapGetters({ parcelsPerimeters: "geoportal/parcels" }),
    ...mapGetters({ concessionsPerimeters: "geoportal/concessions" }),
  },

  methods: {
    ...mapActions({
      setMap: "geoportal/setMap",
      getPerimeter: "geoportal/getDevelopmentUnits",
      getParcelsPerimeters: "geoportal/getParcelsVectors",
      getConcessionsPerimeters: "geoportal/getConcessions",
    }),

    renderPerimeter(perimeters, perimetersVector, isShown) {
      if (isShown) {
        /* Iterate the features to print each perimeter */
        for (const feature of perimeters.features) {
          var coords = [];
          for (const coordsWrapper of feature.geometry.coordinates) {
            for (const coord of coordsWrapper) {
              coords.push(fromLonLat([coord[1], coord[0]]));
            }
          }

          var f = new ol.Feature(new ol.Polygon([coords]));
          f.set("id", feature.properties.id);
          f.set("type", feature.type);

          var vector = new ol.LayerVector({
            source: new ol.Vector({ features: [f] }),
            style: new ol.Style({
              stroke: new ol.Stroke({
                width: 2,
                color: "rgba(52, 163, 79, 0.8)",
              }),
              fill: new ol.Fill({ color: "rgba(52, 163, 79, 0.5)" }),
            }),
          });

          perimetersVector.push(vector);
          this.map.addLayer(vector);
        }

        // Select  interaction
        var select = new Select({
          hitTolerance: 5,
          multi: true,
          condition: singleClick,
        });
        this.map.addInteraction(select);

        // Select control
        var popup = new olExt.PopupFeature({
          popupClass: "default anim",
          select: select,
          canFix: true,
          template: {
            title: function (f) {
              return "Perimeter";
            },
          },
        });
        this.map.addOverlay(popup);
      } else {
        for (const vector of perimetersVector) {
          vector.setVisible(false);
        }
      }
      this.setMap(this.map);
    },

    renderParcels(isShown = true) {
      this.renderPerimeter(
        this.parcelsPerimeters,
        this.parcelsVectors,
        isShown
      );
    },

    renderConcessions(isShown = true) {
      this.renderPerimeter(
        this.concessionsPerimeters,
        this.concessionsVectors,
        isShown
      );
    },
  },

  watch: {
    volViewParcels: function (newVal, oldVal) {
      if (newVal) {
        this.getParcelsPerimeters().then(() => {
          this.renderParcels();
        });
      } else {
        this.renderParcels(false);
      }
    },

    volViewConcessions: function (newVal, oldVal) {
      if (newVal) {
        this.getConcessionsPerimeters().then(() => {
          this.renderConcessions();
        });
      } else {
        this.renderConcessions(false);
      }
    },
  },

  mounted() {},
};
</script>