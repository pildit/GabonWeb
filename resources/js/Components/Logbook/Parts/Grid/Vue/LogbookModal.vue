<template>
    <bmodal ref="logbookModal" size="large" :closed="() => $emit('display', false)">
        <div slot="title">
            <h4 class="modal-title w-100 font-weight-bold">{{translate('logbook_details')}}</h4>
        </div>
        <div slot="body" v-if="state">

            <div class="main-details">
                <table class="table text-left">
                    <tbody>
                    <tr>
                        <td>{{ translate('concession') }}</td>
                        <td class="bold"> {{ (logbook.conession) ? logbook.concession.Name : '' }} </td>
                        <td>{{ translate('ufg') }}</td>
                        <td class="bold">{{ (logbook.managementunit) ? logbook.managementunit.Name : '' }}</td>
                    </tr>
                    <tr>
                        <td>{{ translate('ufa') }}</td>
                        <td class="bold">{{ (logbook.developmentunit) ? logbook.developmentunit.Name: '' }}</td>
                        <td>{{ translate('aac') }}</td>
                        <td class="bold">{{ (logbook.anuualallowablecut) ? logbook.anuualallowablecut.Name : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="items">
                <p class="lead text-center">
                    {{ translate('logbook_items') }}
                </p>
                <div class="text-left">
                    <table class="table table-stripped table-bordered" v-for="(item, i) in logbook.items" :key="'item-' + i">
                        <tbody>
                            <tr>
                                <th>{{ translate('date') }}</th>
                                <td>{{ item.ObserveAt.split(' ')[0] }}</td>
                                <th>{{ translate('tree_id') }}</th>
                                <td>{{ item.TreeId }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('hewing_id') }}</th>
                                <td>{{ item.HewingId }}</td>
                                <th>{{ translate('species') }}</th>
                                <td>{{ item.species.CommonName }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('min_diameter') }}</th>
                                <td>{{ item.MinDiameter }}</td>
                                <th>{{ translate('max_diameter') }}</th>
                                <td>{{ item.MaxDiameter }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('length') }}</th>
                                <td>{{ item.Length }}</td>
                                <th>{{ translate('volume') }}</th>
                                <td>{{ item.Volume }}</td>
                            </tr>
                            <tr>
                                <th>{{ translate('observations') }}</th>
                                <td>{{ item.Note }}</td>
                                <th>{{ translate('approved') }}</th>
                                <td>
                                    <switches v-model="item.Approved" color="green" :title="translate('approve_logbook_item')" @input="approveLogbookItem($event,item.Id)" :emit-on-mount="false" v-tooltip></switches>
                                    <a href="#" class="text-danger fz-16" @click.prevent="deleteItem(item.Id)">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
    import Logbook from "../../../Logbook";

    export default {
        model: {
            prop: 'state',
            event: 'display'
        },

        props: ['state', 'rowProp'],

        components: {bmodal, Switches},

        computed: {
            ...mapGetters('logbooks', ['logbook'])
        },

        watch: {
            state(val) {
                if(!val) return;
                this.$refs.logbookModal.open();
            }
        },

        methods: {
            deleteItem (id) {
                Logbook.delete_item(id).finally(() => {
                    Logbook.get(this.logbook.Id)
                });
            },
            approveLogbookItem (val,id) {
                Logbook.approve_item(id, {Approved: val});
                Logbook.get(this.logbook.Id)
            }
        }
    }
</script>

<style scoped>
    td.bold {
        font-weight: bold;
    }
</style>
