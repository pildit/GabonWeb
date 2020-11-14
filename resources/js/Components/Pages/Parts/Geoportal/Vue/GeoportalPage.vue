<template>
  <div>
    <vol-map>
      <!-- Provider -->
      <vol-layers />
      <vol-perimeter />
      <vol-clustering />
    </vol-map>
    <vol-side-bar />
  </div>
</template>

<script>
import VolMap from "./Map/VolMap";
import VolSideBar from "./Map/VolSideBar";
import VolClustering from "./Map/VolClustering";
import VolPerimeter from "./Map/VolPerimeter.vue";

export default {
  name: "MapContainer",
  components: {
    VolMap,
    VolSideBar,
    VolClustering,
    VolPerimeter,
  },
};
</script>