<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{ translate('product_types') }}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true">
          <i class="fas fa-plus-circle"></i> {{translate('add_product_type')}}
        </button>
      </div>
      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="product_typename">{{ translate('search') }}</label>
            <input @keyup.enter="getProductTypes" class="form-control" v-model="search" type="text" Placeholder="" name="product_typename" id="product_typename" />
          </div>
          <button @click="getProductTypes" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid :columns="grid.columns" :options="grid.options"></grid>
    <product-type-modal :type-prop="formType" v-model="modals.form" @done="getProductTypes"></product-type-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import ProductType from "components/ProductType/ProductType";
import ProductTypeModal from './ProductTypeModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  mixins: [Translation],
  components: {ProductTypeModal,  VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals: {
        form: false
      },
      formType: 'create',
      ProductTypesPagination: {
        total: 0,
        per_page: 20,
        from: 1,
        to: 0,
        current_page: 1
      },
      offset: 4,
      search: null,
    }
  },
  computed: {
  },
  mounted() {
    this.getProductTypes();
  },
  methods: {
    getProductTypes() {
      Vent.$emit('grid-refresh', {search: this.search});
    },
    submit() {
      if(this.formType == 'create') {
        this.save();
      }else{
        this.update();
      }
    },
    closeModal() {
      this.$refs.ProductTypeModal.close();
      this.$emit('done');
      Vent.$emit('grid-refresh');
    },
  }
}
</script>

<style scoped>
.mt-40 {
  margin-top: 40px;
}
.mb-40 {
  margin-bottom: 40px;
}
</style>
