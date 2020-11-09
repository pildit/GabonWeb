<template>
    <div class="container mt-40">
        <h5 class="text-center green-text mb-2">{{translate('Companies')}}</h5>
        <div class="row">
            <div class="col-sm-8 d-flex align-items-center">
                <button class="btn btn-md" @click="addCompany">
                    <i class="fas fa-plus-circle"></i> {{translate('Add Company')}}
                </button>
            </div>
            <div class="md-form col-sm-4">
                <div class="form-row justify-content-end">
                    <div class="col-sm-10">
                        <label for="company_name">{{translate('Search')}}</label>
                        <input @keyup.enter="getCompanies" class="form-control" v-model="search" type="text" Placeholder="" name="company_name" id="company_name" />
                    </div>
                    <button @click="getCompanies" class="btn btn-sm btn-green  px-2" id="filter">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead class="black white-text table-hover">
                <tr>
                    <th scope="col">{{translate('Id')}}</th>
                    <th scope="col">{{translate('Name')}}</th>
                    <th scope="col">{{translate('Types')}}</th>
                    <th scope="col">{{translate('Email')}}</th>
                    <th scope="col">{{translate('Date')}}</th>
                    <th scope="col" class="text-right">{{translate('Action')}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="company in companies">
                    <th scope="row">{{company.Id}}</th>
                    <th>{{company.Name}}</th>
                    <th>{{typesToStr(company.types)}}</th>
                    <th>{{company.Email}}</th>
                    <th>{{company.CreatedAt}}</th>
                    <th class="text-right" v-if="company.name != 'admin'"><span class="btn btn-sm btn-outline-success" @click="editCompany(company.Id)"><i class="fas fa-edit"></i> {{translate('Edit')}}</span></th>
                </tr>
                </tbody>
            </table>
            <vue-pagination :pagination="companiesPagination" @paginate="getCompanies()" :offset="offset"></vue-pagination>
        </div>
        <company-modal :type-prop="formType" v-model="modals.form" @done="getCompanies"></company-modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Translation from "components/Mixins/Translation";
import CompanyModal from './CompanyModal.vue';
import Company from "components/Company/Company";

export default {
    mixins: [Translation],
    components: {VuePagination, CompanyModal},
    data() {
        return {
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
      // this.$store.dispatch('role/permissions');
    },
    methods: {
        updateResource() {
            console.log('UPDATE RES');
        },
        getCompanies() {
            Company.index({page: this.companiesPagination.current_page, per_page: this.companiesPagination.per_page, sort: 'asc', search: this.search})
                .then((pagination) => {
                    this.companiesPagination = pagination;
                })
        },
        addCompany() {
            this.formType = 'create';
            this.modals.form = true
        },
        editCompany(id) {
            this.formType = 'edit';
            Company.get(id).then(() => this.modals.form = true);
        },
        typesToStr: function(items) {
          return _.map(items, 'Name').join('|');
        }
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
