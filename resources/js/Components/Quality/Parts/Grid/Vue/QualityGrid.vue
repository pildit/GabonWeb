<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{ translate('quality') }}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true">
          <i class="fas fa-plus-circle"></i> {{ translate('add_quality') }}
        </button>
      </div>

      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="quality_name">{{ translate('search') }}</label>
            <input @keyup.enter="getQualities" class="form-control" v-model="search" type="text" Placeholder="" name="quality_name" id="quality_name" />
          </div>
          <button @click="getQualities" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid :columns="grid.columns" :options="grid.options"></grid>
    <quality-modal :type-prop="formType" v-model="modals.form" @done="getQualities"></quality-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import Quality from "components/Quality/Quality";
import QualityModal from "./QualityModal";

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  mixins: [Translation],
  components: {QualityModal, VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals : {
        form: false,
      },
      formType: 'create',
      qualitiesPagination: {
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
  props: ['state', 'typeProp'],

  computed: {
  },
  methods: {
    getQualities() {
      Vent.$emit('grid-refresh', {search: this.search});
    },
    submit() {
      if(this.typeProp == 'create') {
        this.$refs.qualityForm.save();
      }else{
        this.$refs.qualityForm.update();
      }
    },
    closeModal() {
      this.$refs.qualityModal.close();
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
