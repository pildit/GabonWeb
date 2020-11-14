<template>
  <div class="line" />
</template>

<script>
/* Vuex */
import store from "store/store";
import { mapGetters, mapState, mapMutations, mapActions } from "vuex";

/* Ol/Ol-Ext */
//import * as ol from "ol";
import olCollection from "ol/Collection";
import olFeature from "ol/Feature";
import olStyle from "ol/style/Style";
import olStyleStroke from "ol/style/Stroke";
import olStyleFlowLine from "ol-ext/style/FlowLine";
import olLayerVectorImage from "ol/layer/VectorImage";
import olSourceVector from "ol/source/Vector";
import olGeomLineString from "ol/geom/LineString";

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
    var defaultStyle = new olStyle({
      stroke: new olStyleStroke({ color: [255, 255, 255, 0.1], width: 2 }),
    });

    // Flow style
    var done = false;
    var flowStyle = new olStyleFlowLine();

    var getStyle = (getStyle = (feature, res) => {
      return [defaultStyle, flowStyle];
    });

    // Nouvelle source de donnee
    var vector = new olLayerVectorImage({
      source: new olSourceVector({ features: new olCollection() }),
      style: getStyle,
    });

    this.map.addLayer(vector);
    vector.getSource().addFeature(
      new olFeature(
        new olGeomLineString([
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