<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{ translate('companies') }}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="modals.form = true">
                    <i class="fas fa-plus-circle"></i> {{ translate('add_company') }}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="company_name">{{translate('search')}}</label>
                        <input @keyup.enter="getCompanies" class="form-control" v-model="search" type="text" Placeholder="" name="company_name" id="company_name" />
                    </div>
                    <button @click="getCompanies" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <grid :columns="grid.columns" :options="grid.options"></grid>
        <company-modal type-prop="create" v-model="modals.form" @done="getCompanies"></company-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import CompanyModal from './CompanyModal.vue';
import Grid from "components/Common/Grid/Grid";
import grid from "../grid";

export default {
    components: {VuePagination, CompanyModal, Grid},
    data() {
        return {
            grid: grid(),
            modals: {
                form: false
            },
            formType: 'create',
            companiesPagination: {
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
      ...mapGetters('company', ['companies']),
    },
    mounted() {
      this.getCompanies();
    },
    methods: {
        getCompanies() {
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
