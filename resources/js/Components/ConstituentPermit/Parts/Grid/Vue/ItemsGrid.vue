<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{ translate('constituent_permits') }}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true"  v-permission="'constituent-permit.add'">
          <i class="fas fa-plus-circle"></i> {{ translate('add_cp') }}
        </button>
      </div>
      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="item_name">{{ translate('search') }}</label>
            <input @keyup.enter="getItems" class="form-control" v-model="search" type="text" Placeholder="" name="item_name" id="item_name" />
          </div>
          <button @click="getItems" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid v-permission="'constituent-permit.view'" :columns="grid.columns" :options="grid.options"></grid>
    <item-modal v-permission="'constituent-permit.edit'" :type-prop="formType" v-model="modals.form" @done="getItems"></item-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Item from "components/ConstituentPermit/ConstituentPermit";
import ItemModal from './ItemModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  components: {ItemModal, VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals: {
        form: false
      },
      formType: 'create',
      itemsPagination: {
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
    this.getItems();
  },
  methods: {
    getItems() {
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
