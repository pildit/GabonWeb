<template>
    <!-- Material form contact -->
    <div class="card" ref="development-unit-form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong v-if="isCreatedFormType">{{ translate("development_unit_create_form_title") }}</strong>
            <strong v-else>{{ translate("development_unit_edit_form_title") }}</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0" v-permission="'development-unit.add'">
            <div class="text-center mt-2" v-if="!isReady">
                <div class="spinner-border text-success" role="status">
                    <span class="sr-only">{{ translate('loading') }}...</span>
                </div>
            </div>
            <!-- Form -->
            <form
                @submit.prevent="save"
                class="text-center"
                novalidate
                style="color: #757575"
                v-if="isReady"
            >
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input
                                :data-vv-as="translate('number_development_unit_form')"
                                @change="alert('x')"
                                class="form-control"
                                id="Number"
                                name="Number"
                                type="text"
                                v-model="form.Number"
                                v-validate="'required'"
                            />
                            <label :class="{ active: form.Number }" for="Number">{{
                                    translate("number_development_unit_form")
                                }}</label>
                            <input-approve @apply="apply($event,'Number')"
                                           v-if="dataToApprove && dataToApprove.Number"
                                           v-model="dataToApprove.Number"
                            ></input-approve>
                            <div class="invalid-feedback" v-show="errors.has('Number')">
                                {{ errors.first("Number") }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input
                                :data-vv-as="translate('name_development_unit_form')"
                                class="form-control"
                                id="Name"
                                name="Name"
                                type="text"
                                v-model="form.Name"
                                v-validate="'required'"
                            />
                            <label :class="{ active: form.Name }" for="Name">{{
                                    translate("name_development_unit_form")
                                }}</label>
                            <input-approve @apply="apply($event,'Name')"
                                           v-if="dataToApprove && dataToApprove.Name"
                                           v-model="dataToApprove.Name"
                            ></input-approve>
                            <div class="invalid-feedback" v-show="errors.has('Name')">
                                {{ errors.first("Name") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input
                                @change="onGeometryChange"
                                class="form-control"
                                id="Geometry"
                                type="text"
                                v-model="form.Geometry"
                                v-validate="'required'"
                            />
                            <label :class="{ active: form.Geometry }" for="Geometry">{{
                                    translate("geometry_input_label")
                                }}</label>
                            <input-approve @apply="apply($event,'Geometry')"
                                           v-if="dataToApprove && dataToApprove.geometry_as_text"
                                           v-model="dataToApprove.geometry_as_text"
                            ></input-approve>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                :allow-empty="false"
                                :hide-selected="true"
                                :loading="concessionsList.isLoading"
                                :options="concessionsList.data"
                                :options-limit="50"
                                :placeholder="translate('concession_select_label')"
                                :searchable="true"
                                @search-change="asyncFindConcession"
                                @select="$forceUpdate()"
                                label="Name"
                                name="concession"
                                track-by="Id"
                                v-model="form.Concession"
                                v-validate="'required'"
                            >
                                <template slot="singleLabel" slot-scope="{ option }"
                                >{{ option.Name }}({{ option.Id }})
                                </template
                                >
                                <template slot="option" slot-scope="{ option }"
                                >{{ option.Name }}({{ option.Id }})
                                </template
                                >
                            </multiselect>
                            <input-approve @apply="apply($event,'Concession')"
                                           v-if="dataToApprove && dataToApprove.Concession"
                                           v-model="dataToApprove.Concession"
                            ></input-approve>
                            <div class="invalid-feedback" v-show="errors.has('concession')">
                                {{ errors.first("concession") }}
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                :options="productTypeList"
                                :placeholder="translate('resource_type_label')"
                                @select="$forceUpdate()"
                                label="Name"
                                name="ProdcutType"
                                track-by="Id"
                                v-model="form.ProductType"
                                v-validate="'required'"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form mt-3 text-left">
                            <label class="position-relative d-block mb-4">{{
                                    translate("select_range_start_end")
                                }}</label>
                            <date-range-picker
                                :linkedCalendars="true"
                                :singleDatePicker="false"
                                @update="updateDates"
                                opens="center"
                                ref="picker"
                                v-model="dateRange"
                            >
                                <template style="min-width: 350px" v-slot:input="picker">
                                    {{ picker.startDate | date }} - {{ picker.endDate | date }}
                                </template>
                            </date-range-picker>
                            <div class="invalid-feedback" v-show="errors.has('dates')">
                                {{ errors.first("dates") }}
                            </div>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
                <div>
                    <div class="form-row"></div>
                </div>
                <plan-form-partial
                    :index="index"
                    :key="index"
                    :ref="`devPlan${index}`"
                    v-for="index in formPlansCount"
                    v-model="plansForm[index - 1]"
                ></plan-form-partial>
                <div class="form-row">
                    <a @click="addPlan()" class="btn btn-info">{{
                            translate("add_ufa_plan")
                        }}</a>
                </div>

                <div class="form-row float-right text-white">
                    <button
                        :disabled="saveLoading"
                        @click="save()"
                        class="btn btn-info z-depth-0 my-4"
                    >
            <span
                aria-hidden="true"
                class="spinner-border spinner-border-sm"
                role="status"
                v-if="saveLoading"
            ></span>
                        {{ translate("save") }}
                    </button>
                    <a :href="indexRoute()" class="btn btn-warning z-depth-0 my-4">{{
                            translate("cancel_button")
                        }}</a>
                </div>
            </form>
            <!-- Form -->
        </div>
    </div>
    <!-- Material form contact -->
</template>

<script>
import _ from "lodash";
import {mapGetters} from "vuex";
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import Multiselect from "vue-multiselect";
import DateRangePicker from "vue2-daterange-picker";
import PlanFormPartial from "./PlanFormPartial";
import Concession from "components/Concession/Concession";
import DevelopmentPlan from "components/Management/DevelopmentPlan/DevelopmentPlan";
import Notification from "components/Common/Notifications/Notification";
import InputApprove from "components/Common/InputApprove";

import {EventBus} from "components/EventBus/EventBus";

export default {
    props: ["developmentUnitProp", "endpointCreate", "endpointEdit"],

    components: {Multiselect, DateRangePicker, PlanFormPartial, InputApprove},

    data() {
        return {
            isReady: true,
            form: {},
            formPlansCount: 0,
            saveLoading: false,
            plansForm: [],
            dateRange: {
                startDate: moment(),
                endDate: moment().add(1, "d"),
            },
            concessionsList: {
                data: [],
                isLoading: false,
            },
            isCreatedFormType: true,
        };
    },

    computed: {
        ...mapGetters("productType", ["productTypeList"]),
        dataToApprove() {
            if (this.developmentUnitProp.hasOwnProperty('log') && !this.developmentUnitProp.Approved) {
                let originalData = JSON.parse(this.developmentUnitProp.log.original_data);
                let data = JSON.parse(this.developmentUnitProp.log.data);
                let diff = this.$diffObj(data, originalData);
                if(diff.hasOwnProperty('Concession')) {
                    diff.Concession = this.concessionsList.data.find((x) => x.['Id'] == diff.Concession);
                }
                return diff;
            }
            return {};
        }
    },

    created() {
        this.form.Start = this.dateRange.startDate.format("YYYY-MM-DD");
        this.form.End = this.dateRange.endDate.format("YYYY-MM-DD");
        this.asyncFindConcession("");
    },

    methods: {
        apply(value, field) {
            this.form[field] = value;
            this.$forceUpdate();
        },
        indexRoute() {
            return DevelopmentUnit.buildRoute("development_units.index");
        },
        save() {
            this.$validator.validate().then((valid) => {
                return new Promise((resolve, reject) => {
                    let validated = false;
                    if (!_.isEmpty(this.plansForm)) {
                        _.each(this.plansForm, (plan, index) => {
                            this.$refs[`devPlan${index + 1}`][0].$validator
                                .validate()
                                .then((validForm) => {
                                    validated = validForm && valid;
                                    resolve(validated);
                                });
                        });
                    } else {
                        resolve(valid);
                    }
                }).then((valid) => {
                    if (valid) {
                        this.saveLoading = true;
                        let promise = this.isCreatedFormType ? this.create : this.update;
                        return promise(this.form).finally(() => (this.saveLoading = false));
                    }
                });
            });
        },
        create(data) {
            data = DevelopmentUnit.buildForm(data);
            return DevelopmentUnit.add(data)
                .then((data) => {
                    Notification.success(
                        this.translate("Development Unit"),
                        data.message
                    );
                    return data.id;
                })
                .then((id) => {
                    _.each(this.plansForm, (plan, index) => {
                        let data = DevelopmentPlan.buildForm(plan, id);
                        DevelopmentPlan.add(data).then((data) => {
                            Notification.success(
                                this.translate("Development Plan"),
                                data.message
                            );
                        });
                    });
                    window.location.href = DevelopmentUnit.buildRoute('development_units.index');
                });
        },
        update(data) {
            data = DevelopmentUnit.buildForm(data);
            return DevelopmentUnit.update(this.form.Id, data)
                .then((data) => {
                    Notification.success(
                        this.translate("Development Unit"),
                        data.message
                    );
                })
                .then(() => {
                    _.each(this.plansForm, (plan, index) => {
                        let data = DevelopmentPlan.buildForm(plan, this.form.Id);
                        let promise = plan.Id
                            ? DevelopmentPlan.update(plan.Id, data)
                            : DevelopmentPlan.add(data);
                        promise.then((data) => {
                            Notification.success(
                                this.translate("development_plan"),
                                data.message
                            );
                        });
                    });
                    // window.location.href = DevelopmentUnit.buildRoute(
                    //   "development_units.index"
                    // );
                });
        },
        asyncFindConcession(query) {
            this.concessionsList.isLoading = true;
            Concession.listSearch(query, this.concessionsList.limit).then(
                (response) => {
                    this.concessionsList.data = response.data;
                    this.concessionsList.isLoading = false;
                    if (this.form.concession) {
                        this.form.Concession = this.concessionsList.data.find(
                            (x) => x["Id"] == this.form.concession.id
                        );
                    }
                }
            );
        },
        addPlan() {
            this.formPlansCount++;
            this.plansForm[this.formPlansCount - 1] = {};
        },
        updateDates(values) {
            this.form.Start = moment(values.startDate).format("YYYY-MM-DD");
            this.form.End = moment(values.endDate).format("YYYY-MM-DD");
        },

        onGeometryChange(value) {
            if (this.endpointEdit) {
                EventBus.$emit(this.endpointEdit, this.form.Geometry);
            }
        },
    },

    watch: {
        developmentUnitProp(value) {
            if (value) {
                // value = value.hasOwnProperty('log') ? JSON.parse(value.log.original_data) : value;
                this.isCreatedFormType = false;
                this.form = _.merge(this.form, value);
                if (value.hasOwnProperty('log')) {
                    this.form = _.merge(this.form, JSON.parse(value.log.original_data));
                }
                this.form.Geometry = value.geometry_as_text;
                this.form.Concession = this.concessionsList.data.find(
                    (x) => x.Id == value.Concession
                );
                this.form.ProductType = this.productTypeList.find(
                    (x) => x.Id == this.form.ProductType
                );
                this.formPlansCount = value.plans.length;
                this.plansForm = value.plans;

                if (this.endpointEdit) {
                    EventBus.$emit(this.endpointEdit, value.geometry_as_text);
                }

                this.dateRange = {
                    startDate: value.Start,
                    endDate: value.End
                }

                this.$forceUpdate();
            }
        },
    },

    mounted() {
        EventBus.$on(this.endpointCreate, (data) => {
            this.form.Geometry = data;
            this.$forceUpdate();
        });
    },
};
</script>

<style scoped>
</style>
