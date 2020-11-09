<template>
  <div>
    <component :is="currentView" :row-prop="rowProp" :options-prop="columnProp.props" :key-prop="keyProp" :column-prop="columnProp" :instance-prop="instance" :index-prop="index"></component>
  </div>
</template>

<script>

import RenderMixin from './Mixins/RenderMixin';

export default {

  props:["rowProp", "columnProp", "keyProp", "instance", "index"],

  mixins: [RenderMixin],

  beforeCreate() {
    this.$options.components[`component-${this.$options.propsData.instance}-${this.$options.propsData.keyProp}`] = this.$options.propsData.columnProp.component;
  },

  data() {
    return  {
      currentView: `component-${this.instance}-${this.keyProp}`
    }
  },

  methods: {

  }
}

</script>

<style>
</style>
