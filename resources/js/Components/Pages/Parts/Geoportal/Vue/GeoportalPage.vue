<template>
  <div>
    <div
      id="map"
      class="map"
      ref="map-root"
      v-bind:style="{ height: window.height + 'px' }"
    ></div>

    <div class="options"></div>

    <!-- Content of the menu -->
    <div id="menu" v-bind:style="{ height: window.height + 'px' }">
      <h1>Menu</h1>
      <p style="border-bottom: 1px solid #999">
        <i>ol.control.Overlay</i> can be used to display a menu or information
        on the top of the map.
      </p>
      <div class="data"></div>
    </div>
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

import * as ol from "ol";

export default {
  name: "MapContainer",
  data() {
    return {
      zoom: 2,
      center: [0, 0],
      rotation: 0,
      geolocPosition: undefined,
      windowHeight: this.windowHeight,

      window: {
        width: 0,
        height: 0,
      },
    };
  },

  created() {
    window.addEventListener("resize", this.handleResize);
    this.handleResize();
  },

  destroyed() {
    window.removeEventListener("resize", this.handleResize);
  },

  methods: {
    handleResize() {
      this.window.width = window.innerWidth;
      this.window.height = window.innerHeight;
    },
  },

  mounted() {
    window.addEventListener("resize", () => {
      this.windowHeight = window.innerHeight;
    });

    // Cluster Source
    var clusterSource = new olCluster({
      distance: 40,
      source: new olVector(),
    });

    // Addfeatures to the cluster
    function addFeatures(nb) {
      var ext = map.getView().calculateExtent(map.getSize());
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
    }

    // this is where we create the OpenLayers map
    const gabon_coord = fromLonLat([11.609454, -0.803698]);
    var map = new ol.Map({
      // the map will be created using the 'map-root' ref
      target: this.$refs["map-root"],
      layers: [
        // adding a background tiled layer
        new TileLayer({
          source: new OSM(), // tiles are served by OpenStreetMap
        }),
      ],

      //the map view will initially show the whole world
      view: new ol.View({
        zoom: 7,
        center: gabon_coord,
        constrainResolution: true,
      }),
    });

    // Overlay
    var menu = new olExtOverlay({
      closeBox: true,
      className: "menu",
      content: $("#menu").get(0),
    });
    map.addControl(menu);

    // A toggle control to show/hide the menu
    var t = new olExtToggle({
      html: '<i class="fa fa-bars" ></i>',
      className: "menu",
      title: "Menu",
      onToggle: function () {
        menu.toggle();
      },
    });
    map.addControl(t);

    // Style for the clusters
    var styleCache = {};
    function getStyle(feature, resolution) {
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
    }
    // Animated cluster layer
    var clusterLayer = new olExtAnimatedCluster({
      name: "Cluster",
      source: clusterSource,
      animationDuration: 700,
      // Cluster style
      style: getStyle,
    });

    map.addLayer(clusterLayer);
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
    map.addInteraction(selectCluster);

    /*END*/
  },
};
</script>

<style>
.ol-overlay.menu {
  width: 30%;
  background: #fff;
  color: #333;
  box-shadow: 0px 0px 5px #000;
  padding: 0.5em;
  -webkit-transition: all 0.25s;
  transition: all 0.25s;
}
/* style the close box */
.ol-overlay.menu .ol-closebox {
  color: #369;
  left: 1em;
  top: 0.5em;
}
.ol-overlay.menu .ol-closebox:before {
  content: "\f0c9";
  font-family: FontAwesome;
}
#menu {
  padding-top: 1.5em;
  font-size: 0.9em;
}
/* menu button */
.ol-control.menu {
  top: 0.5em;
  left: 0.5em;
}
.ol-control.menu i {
  color: #fff;
  transition: all .5s ease-in-out;
}
.ol-zoom {
  left: auto;
  right: 0.5em;
}
.ol-rotate {
  right: 3em;
}
.ol-touch .ol-rotate {
  right: 3.5em;
}
/**/
.ol-overlay img {
  max-width: 90%;
}
.ol-overlay.slide-up {
  transform: translateY(100%);
  -webkit-transform: translateY(100%);
}
.ol-overlay.slide-down {
  -webkit-transform: translateY(-100%);
  transform: translateY(-100%);
}
.ol-overlay.slide-left
{	-webkit-transform: translateX(-100%);
  transform: translateX(-100%);
}
.ol-overlay.slide-right {
  -webkit-transform: translateX(100%);
  transform: translateX(100%);
}
.data,
.data p {
  margin: 0;
  text-align: center;
  font-size: 0.9em;
}
</style>