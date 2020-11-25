<template>
    <div class="text-right">
        <button class="btn btn-sm btn-outline-success" @click="viewPermit(rowProp.Id)" v-if="rowProp.name != 'admin'">
            <i class="fas fa-edit"></i>
            {{translate('view')}}
        </button>
<!--        TODO: Approve -->
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
