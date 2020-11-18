<template>
    <div>
        <hr>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" id="planName" class="form-control" v-model="formData.Name">
                    <label for="Name">{{translate('development_plan_form_name')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="col">
                    <div class="md-form">
                        <multiselect
                            v-model="formData.Species"
                            :options="speciesList.data"
                            :placeholder="translate('species_select_label')"
                            track-by="Id"
                            label="Name"
                            :hide-selected="true"
                            :options-limit="50"
                            :searchable="true"
                            :loading="speciesList.isLoading"
                            :allow-empty="false"
                            @search-change="asyncFindSpecies"
                        ></multiselect>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <div class="md-form">
                    <input type="text" id="MinimumExploitableDiameter" class="form-control" v-model="formData.MinimumExploitableDiameter">
                    <label for="Name">{{translate('development_plan_form_min_exploit_diameter')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" id="VolumeTariff" class="form-control" v-model="formData.VolumeTariff">
                    <label for="Name">{{translate('development_plan_form_volume_tariff')}}</label>
                </div>
            </div>
            <div class="col">
                <div class="md-form">
                    <input type="text" id="Increment" class="form-control" v-model="formData.Increment">
                    <label for="Name">{{translate('development_plan_form_name_increment')}}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';

export default {
    model: {
        prop: 'formData',
        event: 'change'
    },

    props: {
        key: String,
        formData: {
            type: Object,
            required: true,
            default() {
                return {
                    Name: null,
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
            speciesList: {
                data: [],
                isLoading: false
            }
        }
    },

    methods: {
        asyncFindSpecies(query) {

        }
    }
}
</script>

<style scoped>

</style>
