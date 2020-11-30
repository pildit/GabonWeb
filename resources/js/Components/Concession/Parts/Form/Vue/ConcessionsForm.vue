<template>
    <div class="card" ref="concessions_form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('concessions_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Number" name="Number" class="form-control"
                                   v-model="form.Number"
                                   :data-vv-as="translate('name_concession_form')"
                                   v-validate="'required'"
                            >
                            <label for="Number" :class="{'active': form.Number}">{{translate('number_concession_form')}}</label>
                            <div v-show="errors.has('Number')" class="invalid-feedback">{{ errors.first('Number') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" name="Name" class="form-control"
                                   v-model="form.Name"
                                   :data-vv-as="translate('name_concession_form')"
                                   v-validate="'required'"
                            >
                            <label for="Name" :class="{'active': form.Name}">{{translate('name_concession_form')}}</label>
                            <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
                        </div>
                    </div>
                </div>
                <div class="md-form">
                    <input type="text" name="Geometry" id="Geometry" class="form-control" @change="onGeometryChange" v-model="form.Geometry" v-validate="'required'">
                    <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
                    <div v-show="errors.has('Geometry')" class="invalid-feedback">{{ errors.first('Geometry') }}</div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="ConstituentPermit"
                                v-validate="'required'"
                                v-model="form.ConstituentPermit"
                                :options="constituentPermitList.data"
                                :placeholder="translate('constituent_permit_select_label')"
                                track-by="Id"
                                label="PermitNumber"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="constituentPermitList.isLoading"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                                @search-change="asyncFindCP"
                            ></multiselect>
                            <div v-show="errors.has('ConstituentPermit')" class="invalid-feedback">{{ errors.first('ConstituentPermit') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="Company"
                                v-model="form.Company"
                                v-validate="'required'"
                                :options="companyList.data"
                                :placeholder="translate('company_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="companyList.isLoading"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                                @search-change="asyncFindCompany"
                            ></multiselect>
                            <div v-show="errors.has('Company')" class="invalid-feedback">{{ errors.first('Company') }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="Continent"
                                v-validate="'required'"
                                v-model="form.Continent"
                                :options="continents"
                                :placeholder="translate('continent_select_label')"
                                track-by="Name"
                                :allow-empty="false"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }} ({{option.Code}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }} ({{option.Code}})</template>
                            </multiselect>
                            <div v-show="errors.has('Continent')" class="invalid-feedback">{{ errors.first('Continent') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                v-model="form.ProductType"
                                :options="productTypeList"
                                :placeholder="translate('resource_type_label')"
                                track-by="Id"
                                label="Name"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="form-row float-right">
                    <button @click="save()" class="btn btn-info z-depth-0 my-4" :disabled="saveLoading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saveLoading"></span>
                        {{ translate('save') }}
                    </button>
                    <a class="btn btn-warning z-depth-0 my-4" :href="indexRoute()">{{translate('cancel_button')}}</a>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex';
import Multiselect from 'vue-multiselect';
import Company from "components/Company/Company";
import Concession from "components/Concession/Concession";
import ConstituentPermit from "components/ConstituentPermit/ConstituentPermit";
import Notification from "components/Common/Notifications/Notification";
import _ from "lodash";

import { EventBus } from "components/EventBus/EventBus";

export default {

    props: ['concessionProp', 'endpointCreate', 'endpointEdit'],

    components: {Multiselect},

    data() {
        return {
            form: {},
            saveLoading: false,
            constituentPermitList: {
                data: [],
                isLoading: false,
                limit: 50
            },
            companyList: {
                data: [],
                isLoading: false,
                limit: 50
            },
            continentList: {
                data: []
            },
            isCreatedFormType: true
        }
    },

    computed: {
        ...mapState(['continents']),
        ...mapGetters('productType', ['productTypeList']),
    },

    created() {
        this.asyncFindCompany();
        this.asyncFindCP();
    },

    methods: {
        indexRoute() {
            return Concession.buildRoute('concessions.index');
        },
        save() {
            this.$validator.validate().then((valid) => {
                if(valid) {
                    this.saveLoading = true;
                    let promise = this.isCreatedFormType ? this.create : this.update
                    return promise(this.form).finally(() => this.saveLoading = false);
                }
            })
        },
        create(data) {
            data = Concession.buildForm(data);
            return Concession.add(data).then((data) => {
                Notification.success(this.translate('concessions'), data.message);
                window.location.href = this.indexRoute();
            })
        },
        update(data) {
            data = Concession.buildForm(data);
            return Concession.update(this.concessionProp.Id, data).then((data) => {
                Notification.success(this.translate('concessions'), data.message);
                window.location.href = this.indexRoute();
            })

        },
        asyncFindCP(query = '') {
            this.constituentPermitList.isLoading = true;
            ConstituentPermit.listSearch(query, this.constituentPermitList.limit).then((response) => {
                this.constituentPermitList.data = response.data;
                this.constituentPermitList.isLoading = false;
            })
        },
        asyncFindCompany(query = '') {
            this.companyList.isLoading = true;
            Company.listSearch(query, this.companyList.limit).then((response) => {
                this.companyList.data= response.data;
                this.companyList.isLoading = false;
                // this.form.Company = this.companyList.data.find((x) => x['Id'] == this.form.Company_id);
            })

        },

        onGeometryChange(value) {
            if (this.endpointEdit) {
                EventBus.$emit(this.endpointEdit, this.form.Geometry);
            }
        },
    },

    watch: {
        concessionProp(value) {
            if(value) {
                this.isCreatedFormType = false;
                this.form = _.merge(this.form, value);
                this.form.Geometry = value.geometry_as_text;
                this.form.ConstituentPermit = this.constituentPermitList.data.find((x) => x.Id == value.ConstituentPermit);
                this.form.Company = this.companyList.data.find((x) => x.Id == value.Company);
                this.form.Continent = this.continents.find((x) => x.Name == value.Continent);
                this.form.ProductType = this.productTypeList.find((x) => x.Id == this.form.ProductType);
                this.$forceUpdate();
            }
        }
    },

    mounted() {
        EventBus.$on(this.endpointCreate, (data) => {
            this.form.Geometry = data;
            this.$forceUpdate();
        });
    },
}
</script>

<style scoped>

</style>
