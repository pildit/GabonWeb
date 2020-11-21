<template>
    <div>
        <hr>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`planNumber-${index}`"  class="form-control" v-model="formData.Number">
                    <label :for="`planNumber-${index}}`" :class="{'active': formData.Number}">{{translate('number_management_plan_form')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <multiselect
                        name="species"
                        v-validate="'required'"
                        v-model="selectedSpecies"
                        :options="speciesList.data"
                        :placeholder="translate('species_select_label')"
                        track-by="Id"
                        label="LatinName"
                        :hide-selected="true"
                        :options-limit="50"
                        :searchable="true"
                        :loading="speciesList.isLoading"
                        :allow-empty="false"
                        @search-change="asyncFindSpecies"
                    >
                        <template slot="singleLabel" slot-scope="{ option }">{{ option.LatinName }}({{option.CommonName}})</template>
                        <template slot="option" slot-scope="{option}">{{ option.LatinName }}({{option.CommonName}})</template>
                    </multiselect>
                    <div v-show="errors.has(`species`)" class="invalid-feedback">{{ errors.first(`species`) }}</div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`GrossVolumeUFG-${index}`" name="GrossVolumeUFG" class="form-control"
                           v-model="formData.GrossVolumeUFG"
                           v-validate="'required|numeric'"
                    >
                    <label :for="`GrossVolumeUFG-${index}`" :class="{'active': formData.GrossVolumeUFG}">{{translate('gross_volume_ufg_management_plan_form_label')}}</label>
                    <div v-show="errors.has(`GrossVolumeUFG`)" class="invalid-feedback">{{ errors.first(`GrossVolumeUFG`) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`GrossVolumeYear-${index}`" class="form-control"
                           v-model="formData.GrossVolumeYear"
                           v-validate="'required|numeric'"
                    >
                    <label :for="`GrossVolumeYear-${index}`" :class="{'active': formData.GrossVolumeYear}">{{translate('gross_volume_year_management_plan_form_label')}}</label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`YieldVolumeYear-${index}`" class="form-control"
                           v-model="formData.YieldVolumeYear"
                           v-validate="'required|numeric'"
                    >
                    <label :for="`YieldVolumeYear-${index}`" :class="{'active': formData.YieldVolumeYear}">{{translate('yield_volume_year_management_plan_form_label')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`CommercialVolumeYear-${index}`" class="form-control"
                           v-model="formData.CommercialVolumeYear"
                           v-validate="'required|numeric'"
                    >
                    <label :for="`CommercialVolumeYear-${index}`" :class="{'active': formData.CommercialVolumeYear}">{{translate('comercial_volume_year_management_plan_form_label')}}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import Species from "components/Species/Species";

export default {
    model: {
        prop: 'formData',
        event: 'change'
    },

    props: {
        index: Number,
        formData: {
            type: Object,
            required: true,
            default() {
                return {
                    Number: null,
                    Species: null,
                    GrossVolumeUFG : null,
                    GrossVolumeYear: null,
                    YieldVolumeYear: null,
                    CommercialVolumeYear: null
                }
            }
        }
    },

    components: {Multiselect},

    data() {
        return {
            selectedSpecies: null,
            speciesList: {
                data: [],
                isLoading: false,
                limit: 50
            }
        }
    },

    mounted() {
        this.asyncFindSpecies('');
    },

    methods: {
        asyncFindSpecies(query) {
            this.speciesList.isLoading = true;
            Species.listSearch(query, this.speciesList.limit).then((response) => {
                this.speciesList.data= response.data;
                this.speciesList.isLoading = false;
                this.selectedSpecies = this.speciesList.data.find((x) => x.Id == this.formData.Species)
            })
        },
    },
    watch: {
        selectedSpecies(value) {
            if(value) {
                this.formData.Species = value;
            }
        }
    }
}
</script>

<style scoped>

</style>
