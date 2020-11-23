<template>
    <bmodal ref="siteLogbookModal" size="large" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('site_logbook_details')}}</h4>
        </div>
        <div slot="body" v-if="siteLogbook.managementunit != undefined">

            <div class="main-details">
                <table class="table text-left">
                    <tbody>
                    <tr>
                        <td>{{ translate('concession') }}</td>
                        <td class="bold"> {{ siteLogbook.concession.Name }} </td>
                        <td>{{ translate('ufg') }}</td>
                        <td class="bold">{{ siteLogbook.managementunit.Name }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('ufa') }}</td>
                        <td class="bold">{{ siteLogbook.developmentunit.Name }}</td>
                        <td>{{ translate('aac') }}</td>
                        <td class="bold">{{ siteLogbook.anuualallowablecut.Name }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('company') }}</td>
                        <td class="bold">{{ siteLogbook.company.Name }}</td>
                        <td>{{ translate('hammer') }}</td>
                        <td class="bold">{{ siteLogbook.Hammer }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('localization') }}</td>
                        <td class="bold">{{ siteLogbook.Localization }}</td>
                        <td>{{ translate('report_number') }}</td>
                        <td class="bold">{{ siteLogbook.ReportNo }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('report_note') }}</td>
                        <td colspan="3" class="bold">{{ siteLogbook.ReportNote }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="items">
                <p class="lead text-center">
                    {{ translate('site_logbook_items') }}
                </p>
                <div class="text-left">
                    <table class="table table-stripped table-bordered" v-for="(item, i) in siteLogbook.items" :key="'item-' + i">
                        <tbody>
                            <tr>
                                <th>{{ translate('date') }}</th>
                                <td class="bold">{{ item.ObserveAt.split(' ')[0] }}</td>
                                <th>{{ translate('hewing_id') }}</th>
                                <td class="bold">{{ item.HewingId }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('min_diameter') }}</th>
                                <td class="bold">{{ item.MinDiameter }}</td>
                                <th>{{ translate('max_diameter') }}</th>
                                <td class="bold">{{ item.MaxDiameter }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('length') }}</th>
                                <td class="bold">{{ item.Length }}</td>
                                <th>{{ translate('volume') }}</th>
                                <td class="bold">{{ item.Volume }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('species') }}</th>
                                <td class="bold">{{ (item.family) ? item.family.CommonName : '' }}</td>
                                <th>{{ translate('actions') }}</th>
                                <td class="bold">
                                    <switches v-model="item.Approved" color="green" :title="translate('approve_logbook_item')" @input="approveLogbookItem(item.Id)" :emit-on-mount="false" v-tooltip></switches>
                                    <button class="btn btn-sm btn-info" @click="openLogsModal(item.Id)">
                                        <i class="fa fa-info"></i> {{ translate('logs') }}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        <site-logbook-item-log-modal @display="displayEvent" :row-prop="rowProp" v-model="modal.logs"></site-logbook-item-log-modal>
        </div>
    </bmodal>
</template>

<script>

    import bmodal from 'components/Common/BootstrapModal.vue';
    import {mapGetters} from 'vuex';
    import Switches from 'vue-switches';
    import SiteLogbook from "components/SiteLogbook/SiteLogbook";
    import SiteLogbookItemLogModal from "./SiteLogbookItemLogModal";

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },

        props: ['state', 'rowProp'],

        components: {bmodal, Switches, SiteLogbookItemLogModal},

        data () {
            return {
                modal: {
                    logs: false
                }
            }
        },

        computed: {
            ...mapGetters('sitelogbooks', ['siteLogbook'])
        },

        watch: {
            state(val) {
                if(!val) return;
                this.$refs.siteLogbookModal.open();
            }
        },

        methods: {
            openLogsModal (id) {
                SiteLogbook.getItemLogs(id).finally( () => {
                    this.modal.logs = true
                })
            },
            approveLogbookItem (id) {
                SiteLogbook.approve_item(id);
                SiteLogbook.get(this.siteLogbook.Id)
            },
            displayEvent (value) {
                this.modal.logs = value
            }
        }
    }
</script>

<style scoped>
    td.bold {
        font-weight: bold;
    }
</style>
