<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-info" @click="view(rowProp.Id)"><i class="fas fa-info-circle"></i> {{translate('view')}}</span>
        <switches v-model="isApproved" color="green" :title="translate('approve_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <logbook-modal :row-prop="rowProp" v-model="modals.info"></logbook-modal>
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
                Logbook.get(logookId)
                this.modals.info = true
            },
            approve (val) {
               Logbook.approve(this.rowProp.Id).finally(() => this.rowProp.Approved = val);
            },
        }
    }
</script>

<style scoped>

</style>
