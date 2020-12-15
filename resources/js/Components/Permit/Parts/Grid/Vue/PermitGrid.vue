<template>
    <div class="container-fluid mt-40" v-permission="'permit.view'">
        <div class="row">
            <div class="col-md-4">
                <div
                    class="col-md-4"
                    id="geoportalpage"
                    style="position: fixed; padding: 10px"
                >
                    <geoportal-page
                        endpoint-name="transport-permits"
                        hide-sidebar-prop="true"
                    ></geoportal-page>
                </div>
            </div>
            <div class="col-md-8">
                <h5 class="text-center green-text mb-2">
                    {{ translate("transport_permits") }}
                </h5>
                <div class="row">
                    <div class="col-sm-8 d-flex align-items-center"></div>
                    <div class="md-form col-sm-4">
                        <div class="form-row justify-content-end">
                            <div class="col text-right pt-2">
                                <date-range-picker
                                    opens="center"
                                    ref="picker"
                                    :singleDatePicker="false"
                                    v-model="dateRange"
                                    :linkedCalendars="true"
                                    @update="updateDates"
                                >
                                    <template v-slot:input="picker" style="min-width: 350px;">
                                        {{ picker.startDate | date(translate('start_date')) }} - {{ picker.endDate | date(translate('end_date'))}}
                                    </template>
                                </date-range-picker>
                            </div>
                            <div class="col">
                                <label for="role_name">{{ translate("search") }}</label>
                                <input
                                    @keyup.enter="getPermits"
                                    class="form-control"
                                    id="role_name"
                                    name="role_name"
                                    type="text"
                                    v-model="search"
                                />
                            </div>
                            <button
                                @click="getPermits"
                                class="btn btn-sm btn-green px-2"
                                id="filter"
                            >
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <grid :columns="grid.columns" :options="grid.options"></grid>
                <button class="btn btn-outline-info btn-sm" @click.prevent="exportXLS" :disabled="exportLoading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" v-if="exportLoading"></span>
                    Export.xls
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import VuePagination from "components/Common/Grid/VuePagination.vue";
import GeoportalPage from "components/Pages/Parts/Geoportal/Vue/GeoportalPageLeaflet.vue";
import DateRange from "../../../../Mixins/DateRange";
import ExportExcel from "../../../../Mixins/ExportExcel";

import grid from "../grid";
import Grid from "components/Common/Grid/Grid";

export default {

    mixins: [DateRange, ExportExcel],

    components: {VuePagination, Grid, "geoportal-page": GeoportalPage},

    data() {
        return {
            grid: grid(),
            search: null,
            exportUrl: '/api/permits/export',
            exportFilename: 'Transport Permits'
        };
    },
    computed: {
        ...mapGetters("permit", ["permits"]),
    },
    mounted() {
        this.getPermits();
    },
    methods: {
        getPermits() {
            Vent.$emit("grid-refresh", {search: this.search, dateRange: this.dateRange});
        },
    },
};
</script>

<style scoped>
.mt-40 {
    margin-top: 40px;
}
</style>
