<template>
  <div>
    <vol-map>
      <!-- Provider -->
      <vol-layers />
      <vol-perimeter />
      <vol-clustering :volSideCommand="command"/>
      <vol-line />
    </vol-map>
    <vol-side-bar @volSideCommandFunction="executeVolSideCommand($event)" />
  </div>
</template>

<script>
import VolMap from "./Map/VolMap"
import VolSideBar from "./Map/VolSideBar"
import VolClustering from "./Map/VolClustering"
import VolPerimeter from "./Map/VolPerimeter"
import VolLine from "./Map/VolLine"
import VolLayers from "./Map/VolLayers.vue"

import axios from 'axios'

export default {
  name: "MapContainer",

  data() {
    return {
      command: "",
    }
  },

  methods: {
    executeVolSideCommand(command) {
      this.command = command
    },

    /* Methods for VolClustering */
    setAnnualAllowableCutInventoryCluster() {},

    /* Fetches */
    getAnnualAllowableCutInventory() {
      axios
        .get("api/annual_allowable_cut_inventory/vectors")
        .then((response) => (console.log(response)))
    },
  },

  components: {
    VolMap,
    VolLayers,
    VolPerimeter,
    VolClustering,
    VolLine,
    VolSideBar,
  },
}
</script>