<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-info" @click="view(rowProp.Id)"><i class="fas fa-info-circle"></i> {{translate('view')}}</span>
        <switches v-model="isApproved" color="green" :title="translate('approve_site_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <site-logbook-modal @display="displayEvent" :row-prop="rowProp" v-model="modals.info"></site-logbook-modal>
    </div>
</template>

<script>
    import SiteLogbook from "components/SiteLogbook/SiteLogbook";
    import Switches from 'vue-switches';
    import SiteLogbookModal from "./SiteLogbookModal";

    export default {

        props: ["rowProp", "optionsProp"],

        data() {
            return {
                modals: {
                    info: false
                },
            }
        },
        components: {Switches, SiteLogbookModal},
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
            view (logookId) {
                SiteLogbook.get(logookId)
                this.modals.info = true
            },
            approve (val) {
                SiteLogbook.approve(this.rowProp.Id).finally(() => this.rowProp.Approved = val);
            },
            displayEvent (value) {
                this.modal.info = value
            }
        }
    }
</script>

<style scoped>

</style>
