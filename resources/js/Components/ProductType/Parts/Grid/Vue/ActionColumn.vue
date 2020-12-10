<template>
  <div class="text-right">
    <a v-permission="'product-types.edit'" class="text-success aligned fz-16" @click="edit(rowProp.id)" :title="translate('edit')" v-tooltip><i class="fas fa-edit"></i></a>
    <a v-permission="'product-types.delete'" class="text-danger aligned fz-16" @click.prevent="deleteType"
       :title="translate('delete')" v-tooltip><i class="fas fa-trash"></i></a>
    <product-type-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form"></product-type-modal>
  </div>
</template>

<script>
import Translation from "components/Mixins/Translation";
import ProductType from "components/ProductType/ProductType";
import ProductTypeModal from "./ProductTypeModal";
import Confirmation from "../../../../Common/Confirmation/Confirmation";
import PermitType from "../../../../PermitType/PermitType";

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
    deleteType() {
        return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
            if(result.isConfirmed) {
                ProductType.delete(this.rowProp.Id).finally(() => {
                    Vent.$emit('grid-refresh')
                })
            }
        })
    },
    edit(id) {
      this.modals.form = true;
    }
  }
}

</script>

<style scoped>

</style>
