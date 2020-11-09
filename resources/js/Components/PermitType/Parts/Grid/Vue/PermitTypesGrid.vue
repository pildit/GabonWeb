<template>
  <div class="container mt-40">
    <h5 class="text-center green-text mb-2">{{translate('Permit Types')}}</h5>
    <div class="row">
      <div class="col-sm-8 d-flex align-items-center">
        <button class="btn btn-md" @click="modals.form = true">
          <i class="fas fa-plus-circle"></i> {{translate('Add PermitType')}}
        </button>
      </div>
      <div class="md-form col-sm-4">
        <div class="form-row justify-content-end">
          <div class="col-sm-10">
            <label for="company_name">{{translate('Search')}}</label>
            <input @keyup.enter="getPermitTypes" class="form-control" v-model="search" type="text" Placeholder="" name="company_name" id="company_name" />
          </div>
          <button @click="getPermitTypes" class="btn btn-sm btn-green  px-2" id="filter">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    <grid :columns="grid.columns" :options="grid.options"></grid>
    <role-modal :type-prop="formType" v-model="modals.form" @done="getRoles"></role-modal>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import PermitType from "components/PermitType/PermitType";
import PermitTypeModal from './PermitTypesModal.vue';

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {
  mixins: [Translation],
  components: {VuePagination},
  data() {
    return {
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
      PermitType.index({page: this.permitTypesPagination.current_page, per_page: this.permitTypesPagination.per_page, sort: 'asc', search: this.search})
          .then((pagination) => {
            this.permitTypesPagination = pagination;
          })
    },
    save() {
        this.$validator.validate().then((valid) => {
          if(valid) {
            PermitType.add({
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
