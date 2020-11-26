<template>
    <div>
        <hr>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`planNumber-${index}`"  class="form-control" v-model="formData.Number">
                    <label :for="`planNumber-${index}}`" :class="{'active': formData.Number}">{{translate('number_aac_plan_form')}}</label>
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
                    <input type="text" :id="`ExploitableVolume-${index}`" name="ExploitableVolume" class="form-control"
                           v-model="formData.ExploitableVolume"
                           v-validate="'required|decimal:3'"
                    >
                    <label :for="`ExploitableVolume-${index}`" :class="{'active': formData.ExploitableVolume}">{{translate('exploitable_volum_aac_plan_form_label')}}</label>
                    <div v-show="errors.has(`ExploitableVolume`)" class="invalid-feedback">{{ errors.first(`ExploitableVolume`) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`NonExploitableVolume-${index}`" name="NonExploitableVolume" class="form-control"
                           v-model="formData.NonExploitableVolume"
                           v-validate="'required|decimal:3'"
                    >
                    <label :for="`NonExploitableVolume-${index}`" :class="{'active': formData.NonExploitableVolume}">{{translate('non_exploitable_volume_aac_plan_form_label')}}</label>
                    <div v-show="errors.has(`NonExploitableVolume`)" class="invalid-feedback">{{ errors.first(`NonExploitableVolume`) }}</div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`VolumePerHectare-${index}`" name="VolumePerHectare"  class="form-control"
                           v-model="formData.VolumePerHectare"
                           v-validate="'required|decimal:3'"
                    >
                    <label :for="`VolumePerHectare-${index}`" :class="{'active': formData.VolumePerHectare}">{{translate('volume_per_hectare_aac_plan_form_label')}}</label>
                    <div v-show="errors.has(`VolumePerHectare`)" class="invalid-feedback">{{ errors.first(`VolumePerHectare`) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`AverageVolume-${index}`" name="AverageVolume" class="form-control"
                           v-model="formData.AverageVolume"
                           v-validate="'required|decimal:3'"
                    >
                    <label :for="`AverageVolume-${index}`" :class="{'active': formData.AverageVolume}">{{translate('average_volume_aac_plan_form_label')}}</label>
                    <div v-show="errors.has(`AverageVolume`)" class="invalid-feedback">{{ errors.first(`AverageVolume`) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`TotalVolume-${index}`" name="TotalVolume" class="form-control"
                           v-model="formData.TotalVolume"
                           v-validate="'required|decimal:3'"
                    >
                    <label :for="`TotalVolume-${index}`" :class="{'active': formData.TotalVolume}">{{translate('total_volume_aac_plan_form_label')}}</label>
                    <div v-show="errors.has(`TotalVolume`)" class="invalid-feedback">{{ errors.first(`TotalVolume`) }}</div>
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
