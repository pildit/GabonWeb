<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{ translate('species') }}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true" v-permission="'species.add'">
          <i class="fas fa-plus-circle"></i> {{ translate('add_species') }}
        </button>
      </div>
      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="speciesname">{{ translate('search') }}</label>
            <input @keyup.enter="getSpecies" class="form-control" v-model="search" type="text"  name="speciesname" id="speciesname" />
          </div>
          <button @click="getSpecies" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid v-permission="'species.view'" :columns="grid.columns" :options="grid.options"></grid>
    <species-modal v-permission="'species.add'" :type-prop="formType" v-model="modals.form" @done="getSpecies"></species-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Species from "components/Species/Species";
import SpeciesModal from './SpeciesModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  components: {SpeciesModal, VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals: {
        form: false
      },
      formType: 'create',
      speciesPagination: {
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
    this.getSpecies();
  },
  methods: {
    getSpecies() {
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
