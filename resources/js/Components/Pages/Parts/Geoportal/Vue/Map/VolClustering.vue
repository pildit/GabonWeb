<template>
  <div class="clustering"></div>
</template>

<script>
import * as ol from "ol";

/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

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
    var clusterSource = new olCluster({
      distance: 40,
      source: new olVector(),
    });

    // Addfeatures to the cluster
    var addFeatures = addFeatures = (nb) => {
      var ext = this.map.getView().calculateExtent(this.map.getSize());
      var features = [];
      for (var i = 0; i < nb; ++i) {
        features[i] = new olFeature(
          new olGeomPoint([
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
        style = styleCache[size] = new olStyle.Style({
          image: new olStyle.Circle({
            radius: radius,
            stroke: new olStyle.Stroke({
              color: "rgba(" + color + ",0.5)",
              width: 15,
              //lineDash: dash,
              //lineCap: "butt",
            }),
            fill: new olStyle.Fill({
              color: "rgba(" + color + ",1)",
            }),
          }),
          text: new olStyle.Text({
            text: size.toString(),
            //font: 'bold 12px comic sans ms',
            //textBaseline: 'top',
            fill: new olStyle.Fill({
              color: "#fff",
            }),
          }),
        });
      }
      return style;
    };
    
    // Animated cluster layer
    var clusterLayer = new olExtAnimatedCluster({
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
    var img = new olStyle.Circle({
      radius: 5,
      stroke: new olStyle.Stroke({
        color: "rgba(0,255,255,1)",
        width: 1,
      }),
      fill: new olStyle.Fill({
        color: "rgba(0,255,255,0.3)",
      }),
    });
    var style0 = new olStyle.Style({
      image: img,
    });
    var style1 = new olStyle.Style({
      image: img,
      // Draw a link beetween points (or not)
      stroke: new olStyle.Stroke({
        color: "#fff",
        width: 1,
      }),
    });

    // Select interaction to spread cluster out and select features
    var selectCluster = new olExtSelectCluster({
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
            new olStyle.Style({
              stroke: new olStyle.Stroke({
                color: "rgba(0,0,192,0.5)",
                width: 2,
              }),
              fill: new olStyle.Fill({ color: "rgba(0,0,192,0.3)" }),
              //geometry: new olGeomPolygon([chull]),
              zIndex: 1,
            })
          );
          return s;
        } else {
          return [
            new olStyle.Style({
              image: new olStyle.Circle({
                stroke: new olStyle.Stroke({
                  color: "rgba(0,0,192,0.5)",
                  width: 2,
                }),
                fill: new olStyle.Fill({ color: "rgba(0,0,192,0.3)" }),
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