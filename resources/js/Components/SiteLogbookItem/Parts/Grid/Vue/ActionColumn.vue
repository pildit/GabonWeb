<template>
    <div class="text-right">
        <a v-permission="'site_logbook.view'" class="text-info aligned fz-16"
           @click="view(rowProp.Id)" :title="translate('view_logs')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <switches v-permission="'site_logbook.approve'" v-model="isApproved" color="green" :title="translate('approve_site_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <site-logbook-item-log-modal @display="displayEvent" :row-prop="rowProp" v-model="modals.info"></site-logbook-item-log-modal>
    </div>
</template>

<script>
    import SiteLogbookItem from "components/SiteLogbookItem/SiteLogbookItem";
    import Switches from 'vue-switches';
    import SiteLogbookItemLogModal from "./SiteLogbookItemLogModal";

    export default {

        props: ["rowProp", "optionsProp"],

        data() {
            return {
                modals: {
                    info: false
                },
            }
        },
        components: {Switches, SiteLogbookItemLogModal},
        computed: {
            isApproved: {
                get() {
                    return this.rowProp.Approved
                },
                set(value) {
                    return value;
                }
            }
        },

        methods: {
            view (logbookId) {
                SiteLogbookItem.get(logbookId)
                this.modals.info = true
            },
            approve (val) {
                SiteLogbookItem.approve(this.rowProp.Id, {Approved: val}).finally(() => this.rowProp.Approved = val);
            },
            displayEvent (value) {
                this.modal.info = value
            }
        }
    }
</script>

<style scoped>

</style>
