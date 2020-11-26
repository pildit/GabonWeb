<template>
    <!-- Material form contact -->
    <div class="card" ref="development-unit-form">

        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('development_unit_create_form_title') }}</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0" v-permission="'development-unit.add'">

            <!-- Form -->
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Number" name="Number" class="form-control"
                                   v-model="form.Number"
                                   :data-vv-as="translate('number_development_unit_form')"
                                   v-validate="'required'"
                            >
                            <label for="Number" :class="{'active': form.Number}">{{translate('number_development_unit_form')}}</label>
                            <div v-show="errors.has('Number')" class="invalid-feedback">{{ errors.first('Number') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" name="Name" class="form-control"
                                   v-model="form.Name"
                                   :data-vv-as="translate('name_development_unit_form')"
                                   v-validate="'required'"
                            >
                            <label for="Name" :class="{'active': form.Name}">{{translate('name_development_unit_form')}}</label>
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
                                name="concession"
                                v-validate="'required'"
                                v-model="form.Concession"
                                :options="concessionsList.data"
                                :placeholder="translate('concession_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="concessionsList.isLoading"
                                :allow-empty="false"
                                @search-change="asyncFindConcession"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }}({{option.Id}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }}({{option.Id}})</template>
                            </multiselect>
                            <div v-show="errors.has('concession')" class="invalid-feedback">{{ errors.first('concession') }}</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="ProdcutType"
                                v-validate="'required'"
                                v-model="form.ProductType"
                                :options="productTypeList"
                                :placeholder="translate('resource_type_label')"
                                track-by="Id"
                                label="Name"
                                @select="$forceUpdate()"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form mt-3">
                            <label>{{translate("select_range_start_end")}}</label>
                            <date-range-picker
                                opens="center"
                                ref="picker"
                                :singleDatePicker="false"
                                v-model="dateRange"
                                :linkedCalendars="true"
                                @update="updateDates"
                            >
                                <template v-slot:input="picker" style="min-width: 350px;">
                                    {{ picker.startDate | date }} - {{ picker.endDate | date}}
                                </template>
                            </date-range-picker>
                            <div v-show="errors.has('dates')" class="invalid-feedback">{{ errors.first('dates') }}</div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
                <div>
                    <div class="form-row">

                    </div>
                </div>
                <plan-form-partial v-for="index in formPlansCount" v-model="plansForm[index-1]" :index="index" :key="index" :ref="`devPlan${index}`"></plan-form-partial>
                <div class="form-row">
                   <a class="btn btn-info" @click="addPlan()">{{translate('add_ufa_plan')}}</a>
                </div>


                <div class="form-row float-right">
                    <button @click="save()" class="btn btn-info z-depth-0 my-4" :disabled="saveLoading">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="saveLoading"></span>
                        {{ translate('save') }}
                    </button>
                    <a class="btn btn-warning z-depth-0 my-4" :href="indexRoute()">{{translate('cancel_button')}}</a>
                </div>

            </form>
            <!-- Form -->

        </div>
    </div>
    <!-- Material form contact -->
</template>

<script>
import _ from 'lodash';
import {mapGetters} from 'vuex';
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import Multiselect from 'vue-multiselect';
import DateRangePicker from 'vue2-daterange-picker';
import PlanFormPartial from "./PlanFormPartial";
import Concession from "components/Concession/Concession";
import DevelopmentPlan from "components/Management/DevelopmentPlan/DevelopmentPlan";
import Notification from "components/Common/Notifications/Notification";

export default {

    props: ['developmentUnitProp'],

    components: {Multiselect, DateRangePicker, PlanFormPartial},

    data() {
      return {
          form: {},
          formPlansCount: 0,
          saveLoading: false,
          plansForm: [],
          dateRange : {
              startDate: moment(),
              endDate: moment().add(1,'d')
          },
          concessionsList: {
              data: [],
              isLoading: false,
          },
          isCreatedFormType: true
      }
    },

    computed: {
        ...mapGetters('productType', ['productTypeList']),
    },

    created() {
        this.form.Start = this.dateRange.startDate.format('YYYY-MM-DD');
        this.form.End = this.dateRange.endDate.format('YYYY-MM-DD');
        this.asyncFindConcession('');
    },

    methods: {
        indexRoute() {
            return DevelopmentUnit.buildRoute('development_units.index');
        },
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
            data = DevelopmentUnit.buildForm(data);
            return DevelopmentUnit.add(data).then((data) => {
                Notification.success(this.translate('Development Unit'), data.message);
                return data.id
            }).then((id) => {
                _.each(this.plansForm, (plan, index) => {
                    let data = DevelopmentPlan.buildForm(plan, id);
                    DevelopmentPlan.add(data).then((data) => {
                        Notification.success(this.translate('Development Plan'), data.message);
                    })
                })
                // window.location.href = DevelopmentUnit.buildRoute('development_units.index');
            })
        },
        update(data) {
            data = DevelopmentUnit.buildForm(data);
            return DevelopmentUnit.update(this.form.Id, data).then((data) => {
                Notification.success(this.translate('Development Unit'), data.message);
            }).then(() => {
                _.each(this.plansForm, (plan, index) => {
                    let data = DevelopmentPlan.buildForm(plan, this.form.Id);
                    let promise = (plan.Id) ? DevelopmentPlan.update(plan.Id,data) : DevelopmentPlan.add(data);
                    promise.then((data) => {
                        Notification.success(this.translate('development_plan'), data.message);
                    })
                })
                window.location.href = DevelopmentUnit.buildRoute('development_units.index');
            })
        },
        asyncFindConcession(query) {
            this.concessionsList.isLoading = true;
            Concession.listSearch(query, this.concessionsList.limit).then((response) => {
                this.concessionsList.data= response.data;
                this.concessionsList.isLoading = false;
                if(this.form.concession) {
                    this.form.Concession = this.concessionsList.data.find((x) => x['Id'] == this.form.concession.id);
                }
            })

        },
        addPlan() {
            this.formPlansCount++;
            this.plansForm[this.formPlansCount - 1] = {};
        },
        updateDates(values) {
            this.form.Start = moment(values.startDate).format('YYYY-MM-DD');
            this.form.End = moment(values.endDate).format('YYYY-MM-DD');
        },

    },

    watch: {
        developmentUnitProp(value) {
            if(value) {
                this.isCreatedFormType = false;
                this.form = _.merge(this.form, value);
                this.form.Geometry = value.geometry_as_text;
                this.form.Concession = this.concessionsList.data.find((x) => x.Id == value.concession.Id);
                this.form.ProductType = this.productTypeList.find((x) => x.Id == this.form.ProductType);
                this.formPlansCount = value.plans.length;
                this.plansForm = value.plans;
                this.$forceUpdate();
            }
        }
    }

}
</script>

<style scoped>

</style>
