<template>
    <bmodal ref="siteLogbookItemLogModal" size="large" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('site_logbook_logs')}}</h4>
        </div>
        <div slot="body">

            <div class="main-details">
                <table class="table text-left">
                    <tbody>
                    <tr>
                        <td>{{ translate('concession') }}</td>
                        <td class="bold"> {{ rowProp.concession_name }} </td>
                        <td>{{ translate('aac') }}</td>
                        <td class="bold">{{ rowProp.aac_name }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('localization') }}</td>
                        <td class="bold">{{ rowProp.Localization }}</td>
                        <td>{{ translate('report_number') }}</td>
                        <td class="bold">{{ rowProp.ReportNo }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('report_note') }}</td>
                        <td colspan="3" class="bold">{{ rowProp.ReportNote }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="items" v-if="itemLogs.length > 0">
                <p class="lead text-center">
                    {{ translate('site_logbook_items') }}
                </p>
                <div class="text-left">
                    <table class="table table-stripped table-bordered" v-for="(item, i) in itemLogs" :key="'log-' + i">
                        <tbody>
                        <tr>
                            <th>{{ translate('date') }}</th>
                            <td class="bold">{{ item.ObserveAt.split(' ')[0] }}</td>
                            <th>{{ translate('evacuation_date') }}</th>
                            <td class="bold">{{ item.HewingId }}</td>
                        </tr>
                        <tr>
                            <th>{{ translate('site_logbook_item') }}</th>
                            <td class="bold">{{ item.SiteLogbookItem }}</td>
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
                            <th>{{ translate('lat') }}</th>
                            <td class="bold">{{ item.Lat }}</td>
                            <th>{{ translate('lon') }}</th>
                            <td class="bold">{{ item.Lon }}</td>
                        </tr>
                        <tr>
                            <th>{{ translate('note') }}</th>
                            <td class="bold" colspan="3">{{ item.Note }}</td>
                        </tr>
                        <tr>
                            <th>{{ translate('species') }}</th>
                            <td class="bold">{{ item.species.CommonName }}</td>
                            <th>{{ translate('actions') }}</th>
                            <td class="bold">
                                <switches v-model="item.Approved" color="green" :title="translate('approve_logbook_item')" @input="approveLog(item.Id)" :emit-on-mount="false" v-tooltip></switches>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </bmodal>
</template>

<script>

    import bmodal from 'components/Common/BootstrapModal.vue';
    import {mapGetters} from 'vuex';
    import Switches from 'vue-switches';

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },

        props: ['state', 'rowProp'],

        components: {bmodal, Switches},
        data () {
            return {
                modal: {
                    logs: false,
                }
            }
        },
        computed: {
            ...mapGetters('sitelogbookitems', ['itemLogs'])
        },

        watch: {
            state(val) {
                if(!val) return;
                this.$refs.siteLogbookItemLogModal.open();
            }
        },
        methods: {
            approveLog (id) {
                // TODO
            }
        }
    }
</script>

<style scoped>
    td.bold {
        font-weight: bold;
    }
</style>
