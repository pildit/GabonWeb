<template>
    <!-- Material form contact -->
    <div class="card" ref="development-unit-form">

        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('development_unit_create_form_title') }}</strong>
        </h5>

        <!--Card content-->
        <div class="card-body px-lg-5 pt-0">

            <!-- Form -->
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>

                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Name" class="form-control" v-model="form.Name">
                            <label for="Name">{{translate('development_unit_form_name')}}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="Geometry" class="form-control" v-model="form.Geometry">
                            <label for="Geometry">{{translate('geometry_input_label')}}</label>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
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
                            ></multiselect>
                        </div>
                    </div>
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                v-model="form.ProductType"
                                :options="productTypeList.data"
                                :placeholder="translate('resource_type_label')"
                                track-by="Id"
                                label="Name"
                                :allow-empty="false"
                            ></multiselect>
                        </div>
                    </div>
                </div>
                <!-- Name -->
               <div class="form-row">
                   <div class="col">
                       <div class="md-form mt-3">
                           <label>{{translate("select_range_start_end")}}</label>
                           <date-range-picker
                               opens="center"
                               ref="picker"
                               :singleDatePicker="false"
                               :minDate="minDate" :maxDate="maxDate"
                               v-model="dateRange"
                               :linkedCalendars="true"
                           >
                               <template v-slot:input="picker" style="min-width: 350px;">
                                   {{ picker.startDate | date }} - {{ picker.endDate | date}}
                               </template>
                           </date-range-picker>
                       </div>
                   </div>
                   <div class="col"></div>
               </div>
               <div>
                   <div class="form-row">

                   </div>
               </div>
                <plan-form-partial v-for="i in formPlansCount" v-model="plansForm[i-1]" :key="i"></plan-form-partial>
               <div class="form-row">
                   <a class="btn btn-info" @click="addPlan()">{{translate('add_ufa_plan')}}</a>
               </div>


                <div class="form-row float-right">
                    <button class="btn btn-info z-depth-0 my-4" @click="save()">{{translate('save_button')}}</button>
                    <a class="btn btn-warning z-depth-0 my-4" :href="indexRoute">{{translate('cancel_button')}}</a>
                </div>

            </form>
            <!-- Form -->

        </div>
    </div>
    <!-- Material form contact -->
</template>

<script>
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import Multiselect from 'vue-multiselect';
import DateRangePicker from 'vue2-daterange-picker';
import PlanFormPartial from "./PlanFormPartial";

export default {

    components: {Multiselect, DateRangePicker, PlanFormPartial},

    data() {
      return {
          form: {},
          formPlansCount: 0,
          plansForm: [],
          dateRange : {
              startDate: "2020-01-01",
              endDate: "2020-12-31"
          },
          picker: {},
          minDate: "2020-01-01",
          maxDate : "2020-12-31",
          concessionsList: {
              data: [],
              isLoading: false,
          },
          productTypeList: {
              data: [
                  {
                      Id: 1,
                      Name: "Log"
                  }
              ]
          }
      }
    },
    created() {
        this.form.ProductType = this.productTypeList.data[0];
    },

    methods: {
        indexRoute() {
            return DevelopmentUnit.buildRoute('development_units.index');
        },
        save() {

        },
        asyncFindConcession(query) {

        },
        addPlan() {
            this.formPlansCount++;
            this.plansForm[this.formPlansCount - 1] = {};
        },
        updateValues(val) {
            console.log('update ', val);
        },
        checkOpen (open) {
            console.log('event: open', open)
        },
        dateFormat (classes, date) {
            let yesterday = new Date();
            let d1 = dateUtil.format(date, 'isoDate')
            let d2 = dateUtil.format(yesterday.setDate(yesterday.getDate() - 1), 'isoDate')
            if (!classes.disabled) {
                classes.disabled = d1 === d2
            }
            return classes
        }

    }

}
</script>

<style scoped>

</style>
