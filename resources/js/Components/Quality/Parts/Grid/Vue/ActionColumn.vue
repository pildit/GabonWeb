<template>
  <div class="text-right">
    <a v-permission="'quality.edit'" class="text-success aligned fz-16" @click="edit(rowProp.id)" :title="translate('edit')" v-tooltip>
        <i class="fas fa-edit"></i>
    </a>
    <quality-modal :quality-prop="rowProp" type-prop="edit" v-model="modals.form"></quality-modal>
  </div>
</template>

<script>
import qualityModal from "./QualityModal";
import Translation from "components/Mixins/Translation";
import Quality from "components/Quality/Quality";

export default {
  mixins: [Translation],

  props: ["rowProp", "optionsProp"],

  components: {qualityModal},

  data() {
    return {
      modals: {
        form: false
      }
    }
  },

  methods: {
    edit(id) {
      this.modals.form = this.rowProp;
    }
  }
}
</script>

<style scoped>

</style>
