<template>
    <bmodal ref="permitModal" size="large" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('permit_details')}}</h4>
        </div>
        <div slot="body" v-if="permit.annualallowablecut != null">

            <div class="main-details">
                <table class="table text-left">
                    <tbody>
                    <tr>
                        <td>{{ translate('aac_name') }}</td>
                        <td class="bold"> {{ permit.annualallowablecut.Name }} </td>
                        <td>{{ translate('concession_name') }}</td>
                        <td class="bold"> {{ permit.concession === null ? '' : permit.concession.Name }} </td>
                    </tr>
                    <tr>
                        <td>{{ translate('ufa') }}</td>
                        <td class="bold"> {{ permit.developmentunit.Name }} </td>
                        <td>{{ translate('ufg') }}</td>
                        <td class="bold"> {{ permit.managementunit.Name }} </td>
                    </tr>
                    <tr>
                        <td>{{ translate('company_name_concessionaire') }}</td>
                        <td class="bold"> {{ permit.concessionairecompany.Name }} </td>
                        <td>{{ translate('company_name_transporter') }}</td>
                        <td class="bold"> {{ permit.transportercompany.Name }} </td>
                    </tr>
                    <tr>
                        <td>{{ translate('resource_type') }}</td>
                        <td class="bold"> {{ permit.ProductType }} </td>
                        <td>{{ translate('company_client_name') }}</td>
                        <td class="bold"> {{ permit.clientcompany.Name }} </td>
                    </tr>
                    <tr>
                        <td>{{ translate('driver_name') }}</td>
                        <td class="bold"> {{ permit.DriverName }} </td>
                        <td>{{ translate('provenance') }}</td>
                        <td class="bold"> {{ permit.Province }} </td>
                    </tr>
                    <tr>
                        <td>{{ translate('plate_number') }}</td>
                        <td class="bold"> {{ permit.LicensePlate }} </td>
                        <td>{{ translate('destination') }}</td>
                        <td colspan="3" class="bold"> {{ permit.Destination }} </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="items">
                <p class="lead text-center">
                    {{ translate('permit_items') }}
                </p>
                <div class="text-left">
                    <table class="table table-stripped mt-2 table-condensed table-bordered" v-for="(item, i) in permitItems" :key="'item-' + i">
                        <tbody>
                        <tr>
                            <th>{{ translate('date') }}</th>
                            <td class="bold">{{ item.CreatedAt.split(' ')[0] }}</td>
                            <th>{{ translate('log_id') }}</th>
                            <td class="bold">{{ item.LogId }}</td>
                        </tr>
                        <tr>
                            <th>{{ translate('species') }}</th>
                            <td class="bold">{{ item.species.CommonName }}</td>
                            <th>{{ translate('middle_diameter') }}</th>
                            <td class="bold">{{ item.AverageDiameter }}</td>
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
    import Permit from "components/Permit/Permit";

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },

        props: ['state'],

        components: {bmodal, Switches},

        computed: {
            ...mapGetters('permit', ['permit', 'permitItems'])
        },

        watch: {
            state(val) {
                if(!val) return;
                this.$refs.permitModal.open();
            }
        },

        methods: {
        }
    }
</script>

<style scoped>
    td.bold {
        font-weight: bold;
    }
    .table-condensed>tbody>tr>td,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>td,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>thead>tr>th{padding:5px}
</style>
