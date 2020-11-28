<template>
  <div class="container-fluid mt-40">
    <div class="row parcels">
        <div class="col-md-4">
            <div id="geoportalpage" class="col-md-4" style="position: fixed; padding: 10px">
              <geoportal-page hide-sidebar-prop="true" endpoint-name="parcels"></geoportal-page>
            </div>
        </div>
        <div class="col-md-8">
            <h5 class="text-center green-text mb-2">{{translate('Parcels')}}</h5>
            <div class="row">
                <div class="col-sm-6 d-flex align-items-center">
                    <button v-permission="'parcels.add'" class="btn btn-md" @click="modals.form = true">
                        <i class="fas fa-plus-circle"></i> {{translate('Add Parcel')}}
                    </button>
                </div>
                <div class="md-form col-sm-6">
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
                            <label for="item_name">{{translate('Search')}}</label>
                            <input @keyup.enter="getItems" class="form-control" v-model="search" type="text" Placeholder="" name="item_name" id="item_name" />
                        </div>
                        <button @click="getItems" class="btn btn-sm btn-green  px-2" id="filter">
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
            <item-modal :type-prop="formType" v-model="modals.form" @done="getItems"></item-modal>
        </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';
import VuePagination from "components/Common/Grid/VuePagination.vue";
import Item from "components/Parcel/Parcel";
import ItemModal from './ItemModal.vue';
import DateRange from "../../../../Mixins/DateRange";
import ExportExcel from "../../../../Mixins/ExportExcel";
import grid from "../grid";
import Grid from "components/Common/Grid/Grid";
import GeoportalPage from "../../../../Pages/Parts/Geoportal/Vue/GeoportalPageLeaflet.vue";

export default {
  components: {ItemModal, VuePagination, Grid, GeoportalPage},
  mixins: [DateRange, ExportExcel],
  components: {ItemModal, VuePagination, Grid},
  data() {
    return {
      grid: grid(),
      modals: {
        form: false
      },
      exportUrl: '/api/parcels/export',
      exportFilename: 'Parcels',
      formType: 'create',
      itemsPagination: {
        total: 0,
        per_page: 20,
        from: 1,
        to: 0,
        current_page: 1
      },
      offset: 4,
      search: null,
    }
  },
  computed: {
  },
  mounted() {
    this.getItems();
  },
  methods: {
    getItems() {
        Vent.$emit('grid-refresh', {search: this.search, dateRange: this.dateRange});
    },
  }
}
</script>

<style scoped>
.mt-40 {
    margin-top: '40px'
}
.mb-40 {
    margin-bottom: '40px'
}
</style>
