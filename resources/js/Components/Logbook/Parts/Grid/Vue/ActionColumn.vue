<template>
    <div class="text-right">
        <a v-permission="'logbook.view'" class="text-info aligned fz-16" @click="view(rowProp.Id)" :title="translate('view')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <switches v-permission="'logbook.approve'" v-model="rowProp.Approved" color="green" :title="translate('approve_logbook')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
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
