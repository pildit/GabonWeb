<template>
  <div>
    <div class="clustering"></div>
    <!-- <div v-if="volSideCommand" v-html="volSideCommand" /> -->
  </div>
</template>

<script>
import Vue from "vue";

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

/* Ol/Ol-Ext */
import "ol/ol.css";
import "ol-ext/style/defaultStyle";
import * as ol from "../Imports/ol";
import * as olExt from "../Imports/ol-ext";
import { fromLonLat, toLonLat } from "ol/proj";
import "../Imports/ol-ext.css";

import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";

export default {
  name: "VolClustering",

  props: ["volSideCommand"],

  data() {
    return {
      isClusterShown: false,
      clusterSource: null,
      emptyClusterSource: new ol.Cluster({
        distance: 40,
        source: new ol.Vector(),
      }),
      clusterLayer: null,
    };
  },

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
    ...mapGetters({ points: "geoportal/annualAllowableCutInventory" }),
  },

  methods: {
    ...mapActions({
      setMap: "geoportal/setMap",
      getPoints: "geoportal/getAnnualAllowableCutInventory",
    }),

    someMet() {
      console.log("metd called");
    },

    cluster() {
      // this.clusterSetup()
      var clusterSource;
      if (!this.isClusterShown) {
        // Cluster Source
        console.log("FIRST");
        clusterSource = this.emptyClusterSource;
      } else {
        console.log("SECOND");
        this.clusterSetup();
        clusterSource = this.clusterSource;
      }

      // Animated cluster layer
      if (this.clusterLayer != null) {
        this.clusterLayer.setSource(clusterSource);
      }
    },

    clusterSetup() {
      // Cluster Source
      this.clusterSource = new ol.Cluster({
        distance: 40,
        source: new ol.Vector(),
      });

      // Addfeatures to the cluster
      var addFeatures = (addFeatures = () => {
        var ext = this.map.getView().calculateExtent(this.map.getSize());
        var features = [];

        var len;
        if (this.points.length == 0) {
          len = 0;
        } else {
          len = this.points.features.length;
        }

        for (var i = 0; i < len; ++i) {
          features[i] = new ol.Feature(
            new ol.Point(
              fromLonLat([
                this.points.features[i].geometry.coordinates[1],
                this.points.features[i].geometry.coordinates[0],
              ])
            )
          );
          features[i].set("id", i);
        }

        this.clusterSource.getSource().clear();
        this.clusterSource.getSource().addFeatures(features);
      });

      // Style for the clusters
      var styleCache = {};
      var getStyle = (getStyle = (feature, resolution) => {
        var size = feature.get("features").length;
        var style = styleCache[size];
        if (!style) {
          var color =
            size > 25 ? "192,0,0" : size > 8 ? "255,128,0" : "0,128,0";
          var radius = Math.max(8, Math.min(size * 0.75, 20));
          // var dash = (2 * Math.PI * radius) / 6;
          // var dash = [0, dash, dash, dash, dash, dash, dash];
          style = styleCache[size] = new ol.Style({
            image: new ol.Circle({
              radius: radius,
              stroke: new ol.Stroke({
                color: "rgba(" + color + ",0.5)",
                width: 15,
                // lineDash: dash,
                // lineCap: "butt",
              }),
              fill: new ol.Fill({
                color: "rgba(" + color + ",1)",
              }),
            }),
            text: new ol.Text({
              text: size.toString(),
              // font: 'bold 12px comic sans ms',
              // textBaseline: 'top',
              fill: new ol.Fill({
                color: "#fff",
              }),
            }),
          });
        }
        return style;
      });

      // Animated cluster layer
      this.clusterLayer = new olExt.AnimatedCluster({
        name: "Cluster",
        source: this.clusterSource,
        animationDuration: 700,
        // Cluster style
        style: getStyle,
      });

      this.map.addLayer(this.clusterLayer);
      addFeatures();

      // Style for selection
      var img = new ol.Circle({
        radius: 5,
        stroke: new ol.Stroke({
          color: "rgba(0,255,255,1)",
          width: 1,
        }),
        fill: new ol.Fill({
          color: "rgba(0,255,255,0.3)",
        }),
      });
      var style0 = new ol.Style({
        image: img,
      });
      var style1 = new ol.Style({
        image: img,
        // Draw a link beetween points (or not)
        stroke: new ol.Stroke({
          color: "#fff",
          width: 1,
        }),
      });

      // Select interaction to spread cluster out and select features
      var selectCluster = new olExt.SelectCluster({
        // Point radius: to calculate distance between the features
        pointRadius: 7,
        animate: true,
        // Feature style when it springs apart
        featureStyle: function () {
          return [style1];
        },
        // selectCluster: false,	// disable cluster selection
        // Style to draw cluster when selected
        style: function (f, res) {
          var cluster = f.get("features");
          if (cluster.length > 1) {
            var s = [getStyle(f, res)];
            var coords = [];
            for (let i = 0; i < cluster.length; i++)
              coords.push(cluster[i].getGeometry().getFirstCoordinate());
            // var chull = olCoordinate.convexHull(coords);
            s.push(
              new ol.Style({
                stroke: new ol.Stroke({
                  color: "rgba(0,0,192,0.5)",
                  width: 2,
                }),
                fill: new ol.Fill({ color: "rgba(0,0,192,0.3)" }),
                // geometry: new olGeomPolygon([chull]),
                zIndex: 1,
              })
            );
            return s;
          } else {
            return [
              new ol.Style({
                image: new ol.Circle({
                  stroke: new ol.Stroke({
                    color: "rgba(0,0,192,0.5)",
                    width: 2,
                  }),
                  fill: new ol.Fill({ color: "rgba(0,0,192,0.3)" }),
                  radius: 5,
                }),
              }),
            ];
          }
        },
      });

      this.map.addInteraction(selectCluster);

      /*   */
      selectCluster.getFeatures().on(["add"], function (e) {
        counter = counter + 1;
        var content = `
        <div class="table-wrapper-scroll-y my-custom-scrollbar">
          <table class="table table-striped">
           <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">ID</th>
              <th scope="col">Lat</th>
              <th scope="col">Lon</th>
            </tr>
          </thead>
          <tbody>
          `;

        var c = e.element.get("features");

        if (c.length == 1) {
          var feature = c[0];
          const longLat = feature.getGeometry().getFirstCoordinate();
          const coords = toLonLat(longLat);
          const lat = coords[0];
          const long = coords[1];

          content += `<tr><th scope="row">1</th><td>${feature.get(
            "id"
          )} </td><td>${lat}</td> <td>${long}</td></tr>`;

          popup.show(longLat, content);
        } else {
          var counter = 0;
          c.forEach((feature) => {
            content += `<tr><th scope="row">${counter++}</th>`;
            const longLat = feature.getGeometry().getFirstCoordinate();
            const coords = toLonLat(longLat);
            const lat = coords[0];
            const long = coords[1];
            content += `<td><button class="btn btn-primary" v-on:click="name">${feature.get(
              "id"
            )}</button> </td> <td>${lat}</td><td>${long}</td>`;
          });
          content += `</tbody></table></div>`;
          popup.show(c[0].getGeometry().getFirstCoordinate(), content);
        }
      });

      var popup = new olExt.Popup({
        popupClass: "default anim", //"tooltips", "warning" "black" "default", "tips", "shadow",
        closeBox: true,
        onshow: function () {
          console.log("You opened the box");
        },
        onclose: function () {
          console.log("You close the box");
        },
        positioning: "auto",
        autoPan: true,
        autoPanAnimation: { duration: 250 },
      });

      var detailedPopup = new olExt.PopupFeature({
        popupClass: "default anim", //"tooltips", "warning" "black" "default", "tips", "shadow",
        closeBox: true,
        onshow: function () {
          console.log("You opened the box");
        },
        onclose: function () {
          console.log("You close the box");
        },
        positioning: "auto",
        autoPan: true,
        autoPanAnimation: { duration: 250 },
      });

      this.map.addOverlay(popup);
      this.map.addOverlay(detailedPopup);

      // Control Select
      var select = new ol.Select({});
      popup.setPositioning("bottom-center");

      /* Update the stored map */
      this.setMap(this.map);
    },
  },

  watch: {
    volSideCommand: function (newVal, oldVal) {
      this.isClusterShown = !this.isClusterShown;
      this.getPoints().then(() => {
        this.cluster();
      });
    },
  },

  mounted() {
    // this.clusterSetup();
  },
};
</script>
<style>
.my-custom-scrollbar {
  position: relative;
  height: 200px;
  overflow: auto;
}
.table-wrapper-scroll-y {
  display: block;
}
</style>