<template>
    <div class="text-right">
        <a v-permission="'species.edit'" class="text-success aligned fz-16" @click="edit(rowProp.id)" :title="translate('edit')" v-tooltip>
            <i class="fas fa-edit"></i>
        </a>
        <species-modal v-permission="'species.edit'" :row-prop="rowProp" type-prop="edit" v-model="modals.form"></species-modal>
        <a v-permission="'species.delete'" class="text-danger aligned fz-16" @click="deleteItem" :title="translate('delete')" v-tooltip>
            <i class="fas fa-trash"></i>
        </a>
    </div>
</template>

<script>
import speciesModal from "./SpeciesModal";
import Species from "components/Species/Species";
import Confirmation from "../../../../Common/Confirmation/Confirmation";

export default {

    props: ["rowProp", "optionsProp"],

    components: {speciesModal},

    data() {
        return {
            modals: {
                form: false
            }
        }
    },

    methods: {
        deleteItem () {
            return Confirmation(this.translate('corfirmation_delete_question')).then((result) => {
                if(result.isConfirmed) {
                    Species.delete(this.rowProp.Id).finally(() => {
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
