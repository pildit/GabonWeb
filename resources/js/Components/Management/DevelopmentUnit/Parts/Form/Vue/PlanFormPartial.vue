<template>
    <div>
        <hr>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" id="planName" class="form-control" v-model="formData.Number">
                    <label for="planName">{{translate('development_plan_form_id')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="col">
                    <div class="md-form">
                        <multiselect
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
                        <div v-show="errors.has('species')" class="invalid-feedback">{{ errors.first('species') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" id="MinimumExploitableDiameter" class="form-control"
                           v-model="formData.MinimumExploitableDiameter"
                           v-validate="'required'"
                    >
                    <label for="MinimumExploitableDiameter">{{translate('development_plan_form_min_exploit_diameter')}}</label>
                    <div v-show="errors.has('MinimumExploitableDiameter')" class="invalid-feedback">{{ errors.first('MinimumExploitableDiameter') }}</div>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" id="VolumeTariff" class="form-control" v-model="formData.VolumeTariff">
                    <label for="VolumeTariff">{{translate('development_plan_form_volume_tariff')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" id="Increment" class="form-control" v-model="formData.Increment">
                    <label for="Increment">{{translate('development_plan_form_name_increment')}}</label>
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
        this.form = this.formData;
        this.asyncFindSpecies('');
    },

    methods: {
        asyncFindSpecies(query) {
            this.speciesList.isLoading = true;
            Species.listSearch(query, this.speciesList.limit).then((response) => {
                this.speciesList.data= response.data;
                this.speciesList.isLoading = false;
            })
        },
    },
    watch: {
        selectedSpecies(value) {
            this.formData.Species = value;
        }
    }
}
</script>

<style scoped>

</style>
