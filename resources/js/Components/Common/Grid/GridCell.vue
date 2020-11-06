<template>
  <div>
    <component :is="getCellType" :column-prop="columnProp" :row-prop="rowProp" :key-prop="keyProp" :instance="instance" :index="index">
    </component>

  </div>

</template>

<script>

import SimpleCell    from './Cell.vue';
import ComponentCell from './ComponentCell.vue';

export default {

  props:["rowProp", "columnProp", "keyProp", "index", "instance"],

  components: { SimpleCell, ComponentCell },


  data() {
    return  { }
  },

  computed: {

    getCellType() {

      if (this.columnProp.component) {
        return ComponentCell;
      }

      return SimpleCell;
    }

  },

  methods: { }
}

</script>

<style>
</style>
