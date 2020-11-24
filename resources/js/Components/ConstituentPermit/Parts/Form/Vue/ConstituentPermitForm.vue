<template>
    <div class="card" ref="cp_form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('constituent_permit_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">
            <form @submit.prevent="save" class="text-center" style="color: #757575;" novalidate>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <multiselect
                                name="PermitType"
                                v-validate="'required'"
                                v-model="form.PermitType"
                                :options="permitTypeList.data"
                                :placeholder="translate('development_unit_select_label')"
                                track-by="Id"
                                label="Name"
                                :hide-selected="true"
                                :options-limit="50"
                                :searchable="true"
                                :loading="permitTypeList.isLoading"
                                :allow-empty="false"
                                @search-change="asyncFindPermitType"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }}({{option.Id}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }}({{option.Id}})</template>
                            </multiselect>
                            <div v-show="errors.has('DevelopmentUnit')" class="invalid-feedback">{{ errors.first('DevelopmentUnit') }}</div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col">
                        <div class="md-form">
                            <input type="text" id="PermitNumber" name="PermitNumber" class="form-control"
                                   v-model="form.PermitNumber"
                                   :data-vv-as="translate('number_management_unit_form')"
                                   v-validate="'required'"
                            >
                            <label for="Number" :class="{'active': form.PermitNumber}">{{translate('number_management_unit_form')}}</label>
                            <div v-show="errors.has('Number')" class="invalid-feedback">{{ errors.first('Number') }}</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {

    data() {
      return {
          form: {},
          permitTypeList: {
              data: [],
              isLoading: false
          }
      }
    },

    methods: {
        save() {

        },
        asyncFindPermitType(query) {

        }
    }
}
</script>

<style scoped>

</style>
