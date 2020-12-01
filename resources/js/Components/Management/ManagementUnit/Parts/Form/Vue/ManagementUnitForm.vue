<template>
    <div class="card" ref="management-unit-form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('management_unit_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0" v-permission="'management-unit.add'">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Number" name="Number" class="form-control"
                                   v-model="form.Number"
                                   :data-vv-as="translate('number_management_unit_form')"
                                   v-validate="'required'"
                            >
                            <label for="Number" :class="{'active': form.Number}">{{translate('number_management_unit_form')}}</label>
                            <div v-show="errors.has('Number')" class="invalid-feedback">{{ errors.first('Number') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" name="Name" class="form-control"
                                   v-model="form.Name"
                                   :data-vv-as="translate('name_management_unit_form')"
                                   v-validate="'required'"
                            >
                            <label for="Name" :class="{'active': form.Name}">{{translate('name_management_unit_form')}}</label>
                            <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Geometry" class="form-control" @change="onGeometryChange" v-model="form.Geometry" v-validate="'required'">
                            <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="DevelopmentUnit"
                                v-validate="'required'"
                                v-model="form.DevelopmentUnit"
                                :options="developmentUnitList.data"
                                :placeholder="translate('development_unit_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="developmentUnitList.isLoading"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                                @search-change="asyncFindDevelopment"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }}({{option.Id}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }}({{option.Id}})</template>
                            </multiselect>
                            <div v-show="errors.has('DevelopmentUnit')" class="invalid-feedback">{{ errors.first('DevelopmentUnit') }}</div>
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
                <plan-form-partial v-for="index in formPlansCount" v-model="plansForm[index-1]" :index="index" :key="index" :ref="`devPlan${index}`"></plan-form-partial>
                <div class="form-row">
                    <a class="btn btn-info" @click="addPlan()">{{translate('add_ufg_plan')}}</a>
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
import Multiselect from 'vue-multiselect';
import ManagementUnit from "../../../ManagementUnit";
import ManagementPlan from "../../../../ManagementPlan/ManagementPlan";
import PlanFormPartial from "./PlanFormPartial.vue";
import _ from "lodash";
import DevelopmentUnit from "../../../../DevelopmentUnit/DevelopmentUnit";
import Notification from "../../../../../Common/Notifications/Notification";
import {mapGetters} from "vuex";

import { EventBus } from "components/EventBus/EventBus";

export default {

    props : ['managementUnitProp', 'endpointCreate', 'endpointEdit'],

    components: { Multiselect, PlanFormPartial },

    data() {
        return {
            form: {},
            formPlansCount: 0,
            saveLoading: false,
            plansForm: [],
            developmentUnitList: {
                data: [],
                isLoading: false,
                limit: 50
            },
            isCreatedFormType: true
        }
    },
    computed: {
        ...mapGetters('productType', ['productTypeList']),
    },

    created() {
        this.asyncFindDevelopment('');
    },

    methods: {
        save() {
            this.$validator.validate().then((valid) => {

                return new Promise((resolve, reject) => {
                    let validated = false;
                    if(!_.isEmpty(this.plansForm)) {
                        _.each(this.plansForm, (plan, index) => {
                            this.$refs[`devPlan${index + 1}`][0].$validator.validate().then((validForm) => {
                                validated = validForm && valid;
                                resolve(validated)
                            })
                        })
                    }else{
                        resolve(valid);
                    }
                }).then((valid) => {
                    if(valid) {
                        this.saveLoading = true;
                        let promise = this.isCreatedFormType ? this.create : this.update;
                        return promise(this.form).finally(() => this.saveLoading = false);
                    }
                })
            })

        },
        create(data) {
            data = ManagementUnit.buildForm(data);
            return ManagementUnit.add(data).then((data) => {
                Notification.success(this.translate('Management Unit'), data.message);
                return data.id
            }).then((id) => {
                _.each(this.plansForm, (plan, index) => {
                    let data = ManagementPlan.buildForm(plan, id);
                    ManagementPlan.add(data).then((data) => {
                        Notification.success(this.translate('Management Plan'), data.message);
                    })
                })
                window.location.href = ManagementUnit.buildRoute('management_units.index');
            })
        },
        update(data) {
            data = ManagementUnit.buildForm(data);
            return ManagementUnit.update(this.form.Id, data).then((data) => {
                Notification.success(this.translate('Management Unit'), data.message);
            }).then(() => {
                _.each(this.plansForm, (plan, index) => {
                    let data = ManagementPlan.buildForm(plan, this.form.Id);
                    let promise = plan.Id ? ManagementPlan.update(plan.Id, data) : ManagementPlan.add(data);
                    promise.then((data) => {
                        Notification.success(this.translate('Management Plan'), data.message);
                    })
                })
                window.location.href = ManagementUnit.buildRoute('management_units.index');
            })
        },
        asyncFindDevelopment(query) {
            this.developmentUnitList.isLoading = true;
            DevelopmentUnit.listSearch(query, this.developmentUnitList.limit).then((response) => {
                this.developmentUnitList.data = response.data;
                this.developmentUnitList.isLoading = false;
            })
        },
        indexRoute() {
            return ManagementUnit.buildRoute('management_units.index');
        },
        addPlan() {
            this.formPlansCount++;
            this.plansForm[this.formPlansCount - 1] = {};
        },

        onGeometryChange(value) {
            if (this.endpointEdit) {
                EventBus.$emit(this.endpointEdit, this.form.Geometry);
            }
        },
    },
    watch: {
        managementUnitProp(value) {
            if(value) {
                this.isCreatedFormType = false;
                this.form = _.merge(this.form, value);
                this.form.Geometry = value.geometry_as_text;
                this.form.DevelopmentUnit = this.developmentUnitList.data.find((x) => x.Id == value.DevelopmentUnit);
                this.form.ProductType = this.productTypeList.find((x) => x.Id == this.form.ProductType);
                this.formPlansCount = value.plans.length;
                this.plansForm = value.plans;

                if (this.endpointEdit) {
                    EventBus.$emit(this.endpointEdit, value.geometry_as_text);
                }

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
