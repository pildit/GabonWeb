<template>
    <div class="text-right">
        <a v-permission="'permit-types.edit'" class="text-success aligned fz-16" @click="edit()" :title="translate('edit')" v-tooltip >
            <i class="fas fa-edit"></i>
        </a>

        <a v-permission="'permit-types.delete'" class="text-danger aligned fz-16" @click.prevent="deleteType()" :title="translate('delete')" v-tooltip >
            <i class="fas fa-trash"></i>
        </a>
        <permit-types-modal :row-prop="rowProp" type-prop="edit" v-model="modals.form" :key="rowProp.Id"></permit-types-modal>
    </div>
</template>

<script>
import permitTypesModal from "./PermitTypesModal";
import PermitType from "../../../PermitType";
import Confirmation from "../../../../Common/Confirmation/Confirmation";
export default {

    props: ["rowProp", "optionsProp"],

    components: {permitTypesModal},

    data() {
        return {
            modals: {
                form: false
            }
        }
    },

    methods: {
        deleteType () {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    PermitType.delete(this.rowProp.Id).finally(() => {
                        Vent.$emit('grid-refresh')
                    })
                }
            })

        },
        edit() {
            this.modals.form = true;
        }
    }
}

</script>

<style scoped>

</style>
