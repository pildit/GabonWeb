<template>
  <div class="text-right">
    <span class="btn btn-sm btn-outline-success" @click="edit(rowProp.id)" ><i class="fas fa-edit"></i> {{translate('Edit')}}</span>
    <product-type-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></product-type-modal>
  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import ProductType from "components/ProductType/ProductType";
import ProductTypeModal from "./ProductTypeModal";

export default {
  mixins: [Translation],

  props: ["rowProp", "optionsProp"],

  components: {ProductTypeModal},

  data() {
    return {
      modals: {
        form: false
      }
    }
  },

  methods: {
    edit(id) {
      this.modals.form = true;
    }
  }
}

</script>

<style scoped>

</style>
