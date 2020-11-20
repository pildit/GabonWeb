<template>
    <div>
        <hr>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`planNumber-${index}`"  class="form-control" v-model="formData.Number">
                    <label :for="`planNumber-${index}}`" :class="{'active': formData.Number}">{{translate('number_development_plan_form')}}</label>
                </div>
            </div>
            <div class="col">
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
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`MinimumExploitableDiameter-${index}`" name="MinimumExploitableDiameter" class="form-control"
                           v-model="formData.MinimumExploitableDiameter"
                           v-validate="'required|decimal:5|max:8'"
                    >
                    <label :for="`MinimumExploitableDiameter-${index}`" :class="{'active': formData.MinimumExploitableDiameter}">{{translate('min_exploit_diameter_development_plan_form')}}</label>
                    <div v-show="errors.has(`MinimumExploitableDiameter`)" class="invalid-feedback">{{ errors.first(`MinimumExploitableDiameter`) }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`VolumeTariff-${index}`" class="form-control" v-model="formData.VolumeTariff">
                    <label :for="`VolumeTariff-${index}`" :class="{'active': formData.VolumeTariff}">{{translate('volume_tariff_development_plan_form')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" :id="`Increment-${index}`" class="form-control" v-model="formData.Increment">
                    <label :for="`Increment-${index}`" :class="{'active': formData.Increment}">{{translate('increment_development_plan_form')}}</label>
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
                    MinimumExploitableDiameter : null,
                    VolumeTariff: null,
                    Increment: null
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
