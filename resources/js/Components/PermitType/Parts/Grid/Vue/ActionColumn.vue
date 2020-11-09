<template>
    <div class="text-right">
        <span class="btn btn-sm btn-outline-success" @click="edit(rowProp.id)" ><i class="fas fa-edit"></i> {{translate('Edit')}}</span>
        <permit-types-modal type-prop="edit" v-model="modals.form"></permit-types-modal>
    </div>
</template>

<script>
import permitTypesModal from "./PermitTypesModal";
import Translation from "components/Mixins/Translation";
import PermitType from "components/PermitType/PermitType";

export default {
    mixins: [Translation],

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
        editRole(id) {
            Role.get(id).then(() => this.modals.form = true);
        }
    }
}
</script>

<style scoped>

</style>
