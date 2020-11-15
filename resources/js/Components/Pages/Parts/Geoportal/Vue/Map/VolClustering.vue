<template>
  <div class="clustering"></div>
</template>

<script>

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

/* Ol/Ol-Ext */
import "ol/ol.css";
import "ol-ext/style/defaultStyle";

import * as ol from '../Imports/ol'
import * as olExt from '../Imports/ol-ext'

export default {
  name: "VolClustering",

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
  },

  methods: {
    ...mapActions({
      setMap: "geoportal/setMap",
    }),
  },

  mounted() {
    // Cluster Source
    var clusterSource = new ol.Cluster({
      distance: 40,
      source: new ol.Vector(),
    });

    // Addfeatures to the cluster
    var addFeatures = addFeatures = (nb) => {
      var ext = this.map.getView().calculateExtent(this.map.getSize());
      var features = [];
      for (var i = 0; i < nb; ++i) {
        features[i] = new ol.Feature(
          new ol.Point([
            ext[0] + (ext[2] - ext[0]) * Math.random(),
            ext[1] + (ext[3] - ext[1]) * Math.random(),
          ])
        );
        features[i].set("id", i);
      }

      clusterSource.getSource().clear();
      clusterSource.getSource().addFeatures(features);
    };

    // Style for the clusters
    var styleCache = {};
    var getStyle = getStyle = (feature, resolution) => {
      var size = feature.get("features").length;
      var style = styleCache[size];
      if (!style) {
        var color = size > 25 ? "192,0,0" : size > 8 ? "255,128,0" : "0,128,0";
        var radius = Math.max(8, Math.min(size * 0.75, 20));
        //var dash = (2 * Math.PI * radius) / 6;
        //var dash = [0, dash, dash, dash, dash, dash, dash];
        style = styleCache[size] = new ol.Style({
          image: new ol.Circle({
            radius: radius,
            stroke: new ol.Stroke({
              color: "rgba(" + color + ",0.5)",
              width: 15,
              //lineDash: dash,
              //lineCap: "butt",
            }),
            fill: new ol.Fill({
              color: "rgba(" + color + ",1)",
            }),
          }),
          text: new ol.Text({
            text: size.toString(),
            //font: 'bold 12px comic sans ms',
            //textBaseline: 'top',
            fill: new ol.Fill({
              color: "#fff",
            }),
          }),
        });
      }
      return style;
    };
    
    // Animated cluster layer
    var clusterLayer = new olExt.AnimatedCluster({
      name: "Cluster",
      source: clusterSource,
      animationDuration: 700,
      // Cluster style
      style: getStyle,
    });

    this.map.addLayer(clusterLayer);
    // add 2000 features
    addFeatures(2000);

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
              //geometry: new olGeomPolygon([chull]),
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

    /* Update the stored map */
    this.setMap(this.map);
  },
};
</script>