<template>
  <div class="line" />
</template>

<script>
/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

/* Ol/Ol-Ext */
import * as ol from '../Imports/ol'
import * as olExt from '../Imports/ol-ext'

export default {
  name: "VolLine",

  data() {
    return {};
  },

  created() {},

  computed: {
    ...mapGetters({ map: "geoportal/map" }),
  },

  methods: {
    ...mapActions({
      setMap: "geoportal/setMap",
    }),
  },

  mounted() {
    // Default style to make the feature selectable
    var defaultStyle = new ol.Style({
      stroke: new ol.Stroke({ color: [255, 255, 255, 0.1], width: 2 }),
    });

    // Flow style
    var done = false;
    var flowStyle = new olExt.FlowLine();

    var getStyle = (getStyle = (feature, res) => {
      return [defaultStyle, flowStyle];
    });

    // Nouvelle source de donnee
    var vector = new ol.VectorImage({
      source: new ol.Vector({ features: new ol.Collection() }),
      style: getStyle,
    });

    this.map.addLayer(vector);
    vector.getSource().addFeature(
      new ol.Feature(
        new ol.LineString([
          [259274, 6398696],
          [63595, 5958419],
          [635956, 5772524],
        ])
      )
    );

    this.setMap(this.map);
  },
};
</script>