<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{ translate('permit_types') }}</h5>
    <div class="row">
      <div class="col-sm-6 d-flex align-items-center">
        <button v-permission="'permit-types.add'" class="btn btn-md" @click="modals.form = true">
          <i class="fas fa-plus-circle"></i> {{ translate('add_permit_type') }}
        </button>
      </div>
      <div class="md-form col-sm-6">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="permit_type_name">{{ translate('search') }}</label>
            <input @keyup.enter="getPermitTypes" class="form-control" v-model="search" type="text" Placeholder="" name="permit_type_name" id="permit_type_name" />
          </div>
          <button @click="getPermitTypes" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid :columns="grid.columns" :options="grid.options"></grid>
    <permit-types-modal :type-prop="formType" v-model="modals.form" @done="getPermitTypes"></permit-types-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import PermitType from "components/PermitType/PermitType";
import PermitTypesModal from './PermitTypesModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  components: {PermitTypesModal, VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals: {
        form: false
      },
      formType: 'create',
      permitTypesPagination: {
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
    this.getPermitTypes();
  },
  methods: {
    getPermitTypes() {
        Vent.$emit('grid-refresh', {search: this.search});
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
