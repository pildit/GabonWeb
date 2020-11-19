<template>
  <div>
    <vol-map>
      <!-- Provider -->
      <vol-layers />
      <vol-perimeter
        :volViewParcels="viewParcels"
        :volViewConcessions="viewConcessions"
      />
      <vol-clustering :volSideCommand="command" />
      <vol-line />
    </vol-map>
    <vol-side-bar
      @volSideCommandFunction="executeVolSideCommand($event)"
      @onViewParcels="executeOnViewParcels($event)"
      @onViewConcessions="executeOnViewConcessions($event)"
    />
  </div>
</template>

<script>
import VolMap from "./Map/VolMap";
import VolSideBar from "./Map/VolSideBar";
import VolClustering from "./Map/VolClustering";
import VolPerimeter from "./Map/VolPerimeter";
import VolLine from "./Map/VolLine";
// import VolLayers from "./Map/VolLayers.vue"

import axios from "axios";

export default {
  name: "MapContainer",

  data() {
    return {
      command: "",
      viewParcels: false,
      viewConcessions: false,
    };
  },

  methods: {
    executeVolSideCommand(command) {
      this.command = command;
    },

    executeOnViewParcels(viewParcels) {
      this.viewParcels = viewParcels;
    },

    executeOnViewConcessions(viewConcessions) {
      this.viewConcessions = viewConcessions;
    },

    /* Methods for VolClustering */
    setAnnualAllowableCutInventoryCluster() {},
  },

  components: {
    VolMap,
    // VolLayers,
    VolPerimeter,
    VolClustering,
    VolLine,
    VolSideBar,
  },
};
</script>