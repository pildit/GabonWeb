<template>
  <div>
    <vol-map />
    <!-- Provider -->
    <!-- 
      < vol-layers />
      < vol-perimeter /> 
    -->
    <vol-clustering />

    <vol-side-bar />
  </div>
</template>

<script>
import VolMap from "./Map/VolMap";
import VolSideBar from "./Map/VolSideBar";
import VolClustering from "./Map/VolClustering";

export default {
  name: "MapContainer",
  components: {
    VolMap,
    VolSideBar,
    VolClustering,
  },
};
</script>