<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{translate('Species')}}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true">
          <i class="fas fa-plus-circle"></i> {{translate('Add Species')}}
        </button>
      </div>
      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="speciesname">{{translate('Search')}}</label>
            <input @keyup.enter="getSpecies" class="form-control" v-model="search" type="text" Placeholder="" name="speciesname" id="speciesname" />
          </div>
          <button @click="getSpecies" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid :columns="grid.columns" :options="grid.options"></grid>
    <species-modal :type-prop="formType" v-model="modals.form" @done="getSpecies"></species-modal>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import Species from "components/Species/Species";
import SpeciesModal from './SpeciesModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  mixins: [Translation],
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
      Species.index({page: this.speciesPagination.current_page, per_page: this.speciesPagination.per_page, sort: 'asc', search: this.search})
          .then((pagination) => {
            this.speciesPagination = pagination;
          })
    },
    save() {
        this.$validator.validate().then((valid) => {
          if(valid) {
            Species.add({
              Name: this.form.name
            }).then((response) => {
              this.$emit('done');
            }).catch((error) => {
              if(error) {
                this.$setErrorsFromResponse(error.data);
              }
            })
          }
        });
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
