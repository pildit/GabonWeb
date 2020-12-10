<template>
    <div class="text-right">
        <switches v-permission="'permit.approve'" v-model="rowProp.Approved" color="green" :title="translate('approve_permit')" @input="approve" :emit-on-mount="false" v-tooltip></switches>
        <a v-permission="'permit.view'" class="text-info aligned fz-16" @click="viewPermit(rowProp.Id)" :title="translate('view')" v-tooltip>
            <i class="fas fa-info-circle"></i>
        </a>
        <a v-permission="'permit.delete'" class="text-danger aligned fz-16" @click.prevent="deletePermit" :title="translate('delete')" v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
        <permit-modal v-permission="'permit.view'" v-model="modals.view"></permit-modal>
    </div>
</template>

<script>
    import PermitModal from "./PermitModal";
    import Permit from "components/Permit/Permit";
    import Switches from 'vue-switches';
    import Parcel from "../../../../Parcel/Parcel";
    import Confirmation from "../../../../Common/Confirmation/Confirmation";

    export default {

        props: ["rowProp", "optionsProp"],

        components: {PermitModal, Switches},

        data() {
            return {
                modals: {
                    view: false
                }
            }
        },

        methods: {
            deletePermit () {
                return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                    if(result.isConfirmed) {
                        Permit.delete(this.rowProp.Id).finally(() => {
                            Vent.$emit('grid-refresh')
                        })
                    }
                })

            },
            approve (val) {
                Permit.approve(this.rowProp.Id, {Approved: val}).finally(() => this.rowProp.Approved = val);
            },
            viewPermit(id) {
                Permit.get(id);
                Permit.getPermitItems(id).then(() => { this.modals.view = true });
            }
        }
    }
</script>

<style scoped>

</style>
