<template>
  <div>
    <vol-map>
      <!-- Provider -->
      <vol-layers />
      <vol-perimeter />
      <vol-clustering />
      <vol-line />
    </vol-map>
    <vol-side-bar />
  </div>
</template>

<script>
import VolMap from "./Map/VolMap";
import VolSideBar from "./Map/VolSideBar";
import VolClustering from "./Map/VolClustering";
import VolPerimeter from "./Map/VolPerimeter";
import VolLine from './Map/VolLine';
import VolLayers from './Map/VolLayers.vue';

export default {
  name: "MapContainer",
  components: {
    VolMap,
    VolLayers,
    VolPerimeter,
    VolClustering,
    VolLine,
    VolSideBar,
  },
};
</script>