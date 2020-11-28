<template>
    <div class="card" ref="management-unit-form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('aac_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0" v-permission="'AAC.add'">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
<!--                    <div class="col">-->
<!--                        <div class="md-form">-->
<!--                            <input type="text" id="AacId" name="AacId" class="form-control"-->
<!--                                   v-model="form.AacId"-->
<!--                                   :data-vv-as="translate('number_aac_form')"-->
<!--                                   v-validate="'required'"-->
<!--                            >-->
<!--                            <label for="AacId" :class="{'active': form.AacId}">{{translate('number_aac_form')}}</label>-->
<!--                            <div v-show="errors.has('AacId')" class="invalid-feedback">{{ errors.first('AacId') }}</div>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" name="Name" class="form-control"
                                   v-model="form.Name"
                                   :data-vv-as="translate('name_aac_form')"
                                   v-validate="'required'"
                            >
                            <label for="Name" :class="{'active': form.Name}">{{translate('name_aac_form')}}</label>
                            <div v-show="errors.has('Name')" class="invalid-feedback">{{ errors.first('Name') }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Geometry" class="form-control" v-model="form.Geometry" v-validate="'required'">
                            <label for="Geometry" :class="{'active': form.Geometry}">{{translate('geometry_input_label')}}</label>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="ProductType"
                                v-validate="'required'"
                                v-model="form.ProductType"
                                :options="productTypeList"
                                :placeholder="translate('resource_type_label')"
                                track-by="Id"
                                label="Name"
                                :allow-empty="false"
                                @select="$forceUpdate()"
                            ></multiselect>
                            <div v-show="errors.has('ProductType')" class="invalid-feedback">{{ errors.first('ProductType') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="ManagementUnit"
                                v-validate="'required'"
                                v-model="form.ManagementUnit"
                                :options="managementUnitList.data"
                                :placeholder="translate('management_unit_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="managementUnitList.isLoading"
                                :allow-empty="false"
                                @search-change="asyncFindManagementUnit"
                            ></multiselect>
                            <div v-show="errors.has('ManagementUnit')" class="invalid-feedback">{{ errors.first('ManagementUnit') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="ManagementPlan"
                                v-model="form.ManagementPlan"
                                :options="managementPlanList.data"
                                :placeholder="translate('management_plan_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="managementPlanList.isLoading"
                                :allow-empty="false"
                                @search-change="asyncFindManagementPlan"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }}({{option.Id}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }}({{option.Id}})</template>
                            </multiselect>
                            <div v-show="errors.has('ManagementPlan')" class="invalid-feedback">{{ errors.first('ManagementPlan') }}</div>
                        </div>
                    </div>
                </div>
                <plan-form-partial v-for="index in formPlansCount" v-model="plansForm[index-1]" :index="index" :key="index" :ref="`devPlan${index}`"></plan-form-partial>
                <div class="form-row">
                    <a class="btn btn-info" @click="addPlan()">{{translate('add_aac_plan')}}</a>
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
import AAC from "../../../AAC";
import ManagementPlan from "../../../../ManagementPlan/ManagementPlan";
import PlanFormPartial from "./PlanFormPartial.vue";
import _ from "lodash";
import ManagementUnit from "../../../../ManagementUnit/ManagementUnit";
import Notification from "../../../../../Common/Notifications/Notification";
import {mapGetters} from "vuex";
import AACOperationPlan from "../../../AACOperationPlan";

import { EventBus } from "components/EventBus/EventBus";

export default {

    props : ['aacProp', 'endpointName'],

    components: { Multiselect, PlanFormPartial },

    data() {
        return {
            form: {},
            formPlansCount: 0,
            saveLoading: false,
            plansForm: [],
            managementUnitList: {
                data: [],
                isLoading: false,
                limit: 50
            },
            managementPlanList: {
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
        this.asyncFindManagementUnit();
        this.asyncFindManagementPlan();
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
            data = AAC.buildForm(data);
            return AAC.add(data).then((data) => {
                Notification.success(this.translate('aac'), data.message);
                return data.id
            }).then((id) => {
                _.each(this.plansForm, (plan, index) => {
                    let data = AACOperationPlan.buildForm(plan, id);
                    AACOperationPlan.add(data).then((data) => {
                        Notification.success(this.translate('Management Plan'), data.message);
                    })
                })
                window.location.href = AAC.buildRoute('aac.index');
            })
        },
        update(data) {
            data = AAC.buildForm(data);
            return AAC.update(this.form.Id, data).then((data) => {
                Notification.success(this.translate('aac'), data.message);
            }).then(() => {
                _.each(this.plansForm, (plan, index) => {
                    let data = AACOperationPlan.buildForm(plan, this.form.Id);
                    let promise = plan.Id ? AACOperationPlan.update(plan.Id, data) : ManagementPlan.add(data);
                    promise.then((data) => {
                        Notification.success(this.translate('Management Plan'), data.message);
                    })
                })
                // window.location.href = AAC.buildRoute('aac.index');
            })
        },
        asyncFindManagementUnit(query = '') {
            this.managementUnitList.isLoading = true;
            ManagementUnit.listSearch(query, this.managementUnitList.limit).then((response) => {
                this.managementUnitList.data = response.data;
                this.managementUnitList.isLoading = false;
            })
        },
        asyncFindManagementPlan(query = '') {
            this.managementPlanList.isLoading = true;
            ManagementPlan.listSearch(query, this.managementPlanList.limit).then((response) => {
                this.managementPlanList.data = response.data;
                this.managementPlanList.isLoading = false;
            })
        },
        indexRoute() {
            return AAC.buildRoute('aac.index');
        },
        addPlan() {
            this.formPlansCount++;
            this.plansForm[this.formPlansCount - 1] = {};
        },
    },
    watch: {
        aacProp(value) {
            if(value) {
                this.isCreatedFormType = false;
                this.form = _.merge(this.form, value);
                this.form.Geometry = value.geometry_as_text;
                this.form.ManagementUnit = this.managementUnitList.data.find((x) => x.Id == value.ManagementUnit);
                if(value.ManagementPlan) {
                    this.form.ManagementPlan = this.managementPlanList.data.find((x) => x.Id == value.ManagementPlan);
                }
                this.form.ProductType = this.productTypeList.find((x) => x.Id == this.form.ProductType);
                this.formPlansCount = value.annualoperation_plans.length;
                this.plansForm = value.annualoperation_plans;
                this.$forceUpdate();
            }
        }
    },

    mounted() {
        EventBus.$on(this.endpointName, (data) => {
            this.form.Geometry = data;
            this.$forceUpdate();
        });
    },
}
</script>

<style scoped>

</style>
