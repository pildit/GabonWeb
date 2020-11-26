<template>
    <div class="text-right">
        <span v-permission="'logbook.view'" class="btn btn-sm btn-outline-info" @click="view(rowProp.Id)"><i class="fas fa-info-circle"></i> {{translate('view')}}</span>
        <switches v-permission="'logbook.approve'" v-model="isApproved" color="green" :title="translate('approve_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <logbook-modal v-permission="'logbook.view'" :row-prop="rowProp" v-model="modals.info"></logbook-modal>
    </div>
</template>

<script>
    import Logbook from "components/Logbook/Logbook";
    import Switches from 'vue-switches';
    import LogbookModal from "./LogbookModal";

    export default {

        props: ["rowProp", "optionsProp"],

        data() {
            return {
                modals: {
                    info: false
                },
            }
        },
        components: {Switches, LogbookModal},
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
                Logbook.get(logookId).then(() => {
                    this.modals.info = true
                })
            },
            approve (val) {
               Logbook.approve(this.rowProp.Id, {Approved: val}).finally(() => this.rowProp.Approved = val);
            },
        }
    }
</script>

<style scoped>

</style>
