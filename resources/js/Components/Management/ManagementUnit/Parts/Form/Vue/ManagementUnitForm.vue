<template>
    <div class="card" ref="management-unit-form">
        <h5 class="card-header success-color white-text text-center py-4">
            <strong>{{ translate('management_unit_create_form_title') }}</strong>
        </h5>
        <div class="card-body px-lg-5 pt-0">
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
                            <multiselect
                                name="concession"
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
                                @search-change="asyncFindDevelopment"
                            >
                                <template slot="singleLabel" slot-scope="{ option }">{{ option.Name }}({{option.Id}})</template>
                                <template slot="option" slot-scope="{option}">{{ option.Name }}({{option.Id}})</template>
                            </multiselect>
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
import DevelopmentUnit from "components/Management/DevelopmentUnit/DevelopmentUnit";
import ManagementUnit from "../../../ManagementUnit";

export default {

    components: { Multiselect },

    data() {
        return {
            form: {},
            saveLoading: false,
            productTypeList: {
                data: [
                    {
                        Id: 1,
                        Name: "Log"
                    }
                ]
            },
            developmentUnitList: {
                data: [],
                isLoading: false,
                limit: 50
            }
        }
    },

    created() {
        this.asyncFindDevelopment('');
    },

    methods: {
        save() {

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
        }
    }
}
</script>

<style scoped>

</style>
