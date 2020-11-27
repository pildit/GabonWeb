<template>
    <div class="text-right">
        <a class="text-info aligned fz-16" @click="viewPermit(rowProp.Id)" :title="translate('view')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <permit-modal v-model="modals.view"></permit-modal>
    </div>
</template>

<script>
    import PermitModal from "./PermitModal";
    import Permit from "components/Permit/Permit";

    export default {

        props: ["rowProp", "optionsProp"],

        components: {PermitModal},

        data() {
            return {
                modals: {
                    view: false
                }
            }
        },

        methods: {
            viewPermit(id) {
                Permit.get(id);
                Permit.getPermitItems(id).then(() => { this.modals.view = true });
            }
        }
    }
</script>

<style scoped>

</style>
