<template>
  <bmodal ref="ProductTypesModal"  size="medium" :closed="() => $emit('display', false)">
  <div slot="title">
    <h4 class="modal-title w-100 font-weight-bold">{{ translate('add_product_type') }}</h4>
  </div>
    <div slot="body">
      <product-type-form ref="ProductTypeForm" @done="closeModal"></product-type-form>
    </div>
    <div slot="footer">
      <button @click="submit" class="btn btn-default">{{ translate('save')}}</button>
      <button @click="closeModal" class="btn btn-warning">{{ translate('cancel') }}</button>
    </div>
  </bmodal>
</template>

<script>
import Translation from "components/Mixins/Translation";
import bmodal from 'components/Common/BootstrapModal.vue';
import ProductTypeForm from "./ProductTypeForm";
import {mapGetters} from 'vuex';

export default {
  model: {
    prop: 'state',
    event: 'display'
  },
  mixins: [Translation],

  props: ['state', 'typeProp', 'rowProp'],

  components: {bmodal, ProductTypeForm},

  computed: {
    ...mapGetters('productType', ['productType'])
  },

  methods: {
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.ProductTypeForm.save();
      }else{
        this.$refs.ProductTypeForm.update();
      }
    },
    closeModal() {
      this.$refs.ProductTypesModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    }
  },

  watch: {
    state(val) {
      if(!val) return;
      if(this.typeProp != 'create') {
        this.$refs.ProductTypeForm.form = this.rowProp;
      }else{
        this.$refs.ProductTypeForm.form = {};
      }
      this.$refs.ProductTypeForm.errors.clear();
      this.$refs.ProductTypesModal.open();
    }
  }
}
</script>

<style scoped>
</style>
